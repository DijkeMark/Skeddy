$(document).ready(function()
{
	company = new Company();
	$('#registration-complete').hide(0);
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
	if(jsonData.errors.length > 0)
	{
		$('#error').hide(0).html(jsonData.errors).show(500);
	}
	else
	{
		$('#company-registration').hide(0);
		$('#registration-complete').show(0);
	}
}