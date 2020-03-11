>> For add Comment and File Download functionality in email follow below steps:

	1. {{vszcomment}} : Used this Variable in email template file for add comment from user.
	2. {{filename}} : Used this Variable in email template file for add file name which uploaded by user.
	3. {{fileurl}} : Used this Variable in email template file for add link in anchor tag of file name for download.

	Example :
		<tr>
			<div>
				Comment : <p>{{var vszcomment}}</p>
				File : <a href="{{var fileurl}}" download>{{var filename}}</a>
			</div>
		</tr>