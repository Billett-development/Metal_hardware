define([
    'ko',
    'jquery',
    'uiComponent'
], function (ko, $, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Vsourz_Ordercomment/order-comments'
        },
         getEnabled: function () {
                return window.checkoutConfig.enabled;
         },
         getEnabledOrdercomment: function () {
                return window.checkoutConfig.enabledordercomment;
         },
         getEnabledFileupload: function () {
                return window.checkoutConfig.enabledfileupload;
         },
         getfileuploadStatus: function () {
                return window.checkoutConfig.fileuploadstatus;
         },
         getOrdercommentsStatus: function () {
                return window.checkoutConfig.ordercommentsstatus;
         },
         getfileuploadvalue: function () {
                return window.checkoutConfig.fileuploadvalue;
         },
         getOrdercommentTitle: function () {
                return window.checkoutConfig.ordercommenttitle;
         },
         getOrdercommentTexttitle: function () {
                return window.checkoutConfig.ordercommenttexttitle;
         },
         getOrderfileTexttitle: function () {
                return window.checkoutConfig.orderfiletexttitle;
         },
         getOrdercommentbaseurl: function () {
                return window.checkoutConfig.ordercommentbaseurl;
         },
         getFileuploadvalustatus: function () {
                return window.checkoutConfig.fileuploadvaluestatus;
         },
         getOrdercommentfield: function () {
                return window.checkoutConfig.ordercommentfield;

         },
         getOrdercommentfieldNo: function () {
                return window.checkoutConfig.ordercommentfieldno;
         },
         getOrdercommentfile: function () {
                return window.checkoutConfig.ordercommentfile;

         },
         getOrdercommentfileNo: function () {
                return window.checkoutConfig.ordercommentfileno;
         },
         getorderCommentstext: function () {
                return window.checkoutConfig.getordercommentstext;
         },
         getOrdercommentsFiletype: function () {
                return window.checkoutConfig.order_comments_file_type;
         }

    });

});
