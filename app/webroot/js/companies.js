$(document).ready(function()
{
	company = new Company();
});

function Company()
{
	this.SetupClickHandlers();
	this.SetupDragAndDropHandlers();
}

Company.prototype.SetupClickHandlers = function()
{
	var self = this;
	$('#send-invite').on('click', function(event)
	{
    	form = $("#InvitedEmployerInviteForm").serialize();

    	$.ajax(
		{
			url:'/companies/invite',
			type:'post',
			dataType:'json',
			data:form,
			success:function(jsonData)
			{
				self.ProcessInvitations(jsonData);
			}
		});

    	event.preventDefault();
    	return false;
    });
}

Company.prototype.ProcessInvitations = function(jsonData)
{
	if(jsonData.Error != null)
	{
		$('#error').hide(0).html(jsonData.Error).show(500);
	}

	if(jsonData.InvitedEmployers.length > 0)
	{
		for(var i = 0; i < jsonData.InvitedEmployers.length; i++)
		{
			var employer = jsonData.InvitedEmployers[i]['InvitedEmployer'];
			var id = employer['id'];
			var email = employer['email'];

			if($('.invited-employer#' + id).length == 0)
			{
				$('#pending-invitations').append('<div class="invited-employer" id="' + id + '"></div>');
				$('.invited-employer#' + id).hide(0)
				$('.invited-employer#' + id).append('<div class="email left">' + email + '</div>');
				$('.invited-employer#' + id).append('<div class="cancel right">Cancel</div>');
				$('.invited-employer#' + id).append('<div class="clear"></div>');
				$('.invited-employer#' + id).show(500);
			}
		}
	}
}

Company.prototype.SetupDragAndDropHandlers = function(jsonData)
{
	$('#EmployerSetProfilePictureForm #drop-container span').on('click', function(event)
	{
		$('#EmployerUpload-field').click();
    });

    $('#EmployerSetProfilePictureForm').fileupload(
    {
    	dropZone: $('#drop-container'),
    	add: function (e, data)
    	{
            var jqXHR = data.submit();
            console.log(jqXHR);
            jqXHR.success(function()
            {
            	var jsonData = $.parseJSON(jqXHR.responseText);
            	$('#profile-picture #profile-photo').attr('src', '/img/employers/' + jsonData.profile_photo);
            });
        },
    });

    $(document).on('drop dragover', function(event)
    {
        event.preventDefault();
    });
}