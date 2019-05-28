function checkForm() {
	var theName = document.forms["formGb"]["inputNameGb"].value;
	var theEmail = document.forms["formGb"]["inputEmailGb"].value;
	var theComment = document.forms["formGb"]["inputComment"].value;
	if (theName == "" || theEmail == "" || theComment == "") {
		alert("رجاءا أدخل جميع الحقول المطلوبة!!");
		return false;
	}
}
