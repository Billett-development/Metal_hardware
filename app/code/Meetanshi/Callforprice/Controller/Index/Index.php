<?php

namespace Meetanshi\Callforprice\Controller\Index;

use Magento\Directory\Model\CountryFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Meetanshi\Callforprice\Helper\Data as HelperData;
use Meetanshi\Callforprice\Model\Callforprice;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;

class Index extends Action
{
    const XML_PATH_EMAIL_RECIPIENT = 'callforprice/adminemail/emailsender';

    private $jsonFactory;
    private $callforpriceModel;
    private $transportBuilder;
    private $inlineTranslation;
    private $helperData;
    private $countryFactory;
    private $storeManager;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        Callforprice $collectionFactory,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        HelperData $helperData,
        CountryFactory $countryFactory,
        StoreManagerInterface $storeManager
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->callforpriceModel = $collectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->helperData = $helperData;
        $this->countryFactory = $countryFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {

        $response = ['succeess' => true];
        $result = $this->jsonFactory->create();
        if ($this->_request->getParams()) {
            $cname = $this->_request->getParam('cname');
            $email = $this->_request->getParam('email');
            $countryCode = $this->_request->getParam('country_id');
            $phoneNumber = $this->_request->getParam('phone_number');
            $comment = $this->_request->getParam('comment');
            $privacy = $this->_request->getParam('privacy');
            $callforpid = $this->_request->getParam('callProductId');

            if ($cname != "" && $email != "" && $countryCode != "" && $phoneNumber != "" && $comment != "") {
                if (($this->helperData->isEnablePrivacy() && ($privacy != "" || !is_null($privacy))) || !$this->helperData->isEnablePrivacy()) {

                    if ($this->helperData->captchaEnable()) {
                        $token = $this->_request->getParam('g-recaptcha-response');
                        $validation = $this->helperData->validate($token);

                        if (!$validation['success']) {
                            $response = ['succeess' => false];
                            $result->setData($response);
                            $this->messageManager->addErrorMessage(__($validation['error'].'Please Refresh the Page'));
                            return $result;
                        }
                    }

                    try {
                        $resultPage = $this->callforpriceModel;
                        $resultPage->setCname($cname);
                        $resultPage->setEmail($email);
                        $resultPage->setCountry($countryCode);
                        $resultPage->setPhoneNumber($phoneNumber);
                        $resultPage->setComment($comment);
                        $resultPage->setProductid($callforpid);
                        $resultPage->save();
                        $country = $this->countryFactory->create()->loadByCode($countryCode);
                        $this->inlineTranslation->suspend();

                        $from = $this->helperData->getCallforEmailSender();
                        $this->inlineTranslation->suspend();
                        $to = $this->helperData->getAdminEmail();
                        $prdName = $this->helperData->getProdName($callforpid);

                        $templateOptions = [
                            'area' => Area::AREA_FRONTEND,
                            'store' => $this->storeManager->getStore()->getId()
                        ];
                        $templateVars = [
                            'storename' => $this->helperData->getStoreName(),
                            'cname' => $cname,
                            'email' => $email,
                            'country' => $country->getName(),
                            'phonenumber' => $phoneNumber,
                            'message' => $comment,
                            'pname' => $prdName
                        ];
                        $templatePath = $this->helperData->getAdminEmailTemplate($this->storeManager->getStore()->getId());

                        $transport = $this->transportBuilder->setTemplateIdentifier($templatePath)
                            ->setTemplateOptions($templateOptions)
                            ->setTemplateVars($templateVars)
                            ->setFrom($from)
                            ->addTo($to)
                            ->getTransport();
                        $transport->sendMessage();
                        if ($this->helperData->isCustomerAutoReply()) {
                            $this->sendAutoReply($from, $email, $cname, $templateOptions, $prdName);
                        }
                        $this->inlineTranslation->resume();
                        $this->messageManager->addSuccessMessage(__('Your inquiry submitted successfully'));
                        $this->_redirect('*/*/');
                        $result->setData($response);
                        return $result;
                    } catch (\Exception $e) {
                        $this->inlineTranslation->resume();
                        $this->messageManager->addErrorMessage(__("We can\'t process your request" . $e->getMessage()));
                        $this->_redirect('*/*/');
                        $response = ['succeess' => false];
                        $result->setData($response);
                        return $result;
                    }
                } else {
                    $response = ['succeess' => false];
                    $result->setData($response);
                    $this->messageManager->addErrorMessage(__("Please Enter Required Field(s)"));
                    return $result;
                }
            } else {
                $response = ['succeess' => false];
                $result->setData($response);
                $this->messageManager->addErrorMessage(__("Please Enter Required Field(s)"));
                return $result;
            }
        } else {
            $response = ['succeess' => false];
            $result->setData($response);
            return $result;
        }
    }

    public function sendAutoReply($from, $to, $cname, $templateOptions, $prdName)
    {
        $vars = ['cname' => $cname,
            'productname' => $prdName];
        try {
            $autoTemplatePath = $this->helperData->getAutoReplayTemplate($this->storeManager->getStore()->getId());

            $transport = $this->transportBuilder->setTemplateIdentifier($autoTemplatePath)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($vars)
                ->setFrom($from)
                ->addTo($to)
                ->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addErrorMessage(__("We can\'t process your request" . $e->getMessage()));
            $this->_redirect('*/*/');
        }
    }
}