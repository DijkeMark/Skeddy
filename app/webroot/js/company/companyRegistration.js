$(document).ready(function()
{
	company = new Company();
});

function Company()
{
	this.SetupClickHandlers();
}

Company.prototype.SetupClickHandlers = function()
{
	var self = this;
	$('#register-company').on('click', function(event)
	{
    	form = $("#CompanyRegistrationForm").serialize();

    	$.ajax(
		{
			url:'/companies/registration',
			type:'post',
			dataType:'json',
			data:form,
			success:function(jsonData)
			{
				self.ProcessRegistration(jsonData);
			}
		});

    	event.preventDefault();
    	return false;
    });
}

Company.prototype.ProcessRegistration = function(jsonData)
{
	if(jsonData.Error != null)
	{
		$('#error').hide(0).html(jsonData.Error).show(500);
	}
}