require([
		'jquery',
	], function ($) {
		'use strict';
		// console.log(global_adminnote_statusurl);
		// console.log(global_adminnote_deleteurl);
		// console.log(global_adminnote_newurl);
		// console.log(global_adminnote_statusurl);
		// console.log(global_adminnote_saveurl);
		// console.log(global_adminnote_hidden_count);
		var body = $('body');
		body.on(
			'click','.button-save-note',function () {
				var text = $(this).siblings('.note-page-text').val();
				var type = $(this).siblings('.note-page-type').val();
				var title = $(this).siblings('.note-page-type').children("option:selected").text();
				// var type = title ;
				var path = $('#adminNotePath').val();
				var path_id = $('#adminNotePathId').val();
				var user_id = $(this).siblings('.user-admin-id').val();
				$.ajax(
					{
						showLoader: true,
						url: global_adminnote_saveurl,
						type: "POST",
						data:{ path_id: path_id , note: text , type: type, path: path, title: title, user_id: user_id }
					}
				).done(
					function (data) {
						if (data.error) {
							$('#notesContainer').append(data.output);
						}
						return true;
					}
				);
				$(this).parents('.adminnote-container').remove();

			}
		).on(
			'change','.note-page-type', function () {
				var e = $(this).parents('.notification-global');
				var classNames = e.attr('class').split(' ');

				for (var i=0; i<classNames.length; ++i)
				{
					var str = classNames[i];
					if (str.match('adminnote-type-')) {
						e.removeClass(str);
					}
				}
				e.addClass('adminnote-type-'+ $(this).val());

			}
		);


		$('.add-button').on(
			"click", function () {

				$.ajax(
					{
						showLoader: true,
						url: global_adminnote_newurl,
						type: "GET",
					}
				).done(
					function (data) {
						$('#notesContainer').append(data.output);
						return true;
					}
				);
			}
		);

		body.on(
			"click",'.button-cancel-note', function () {
				$(this).parents(".adminnote-container").remove();
			}
		);

		body.on(
			'keyup','.note-page-text', function () {
				$(this).prop('scrollHeight');
				$(this).outerHeight()
				if ($(this).prop('scrollHeight') > $(this).outerHeight() ) {
					$(this).css('height',$(this).prop('scrollHeight'));
				}
			}
		);

		body.on(
			"click",'#delete-note-page', function () {
				var note_id = $(this).siblings('#id-note-page').val();
				var message = $(this).siblings('#message-to-customer').val();
				if(confirm(message)) {
					$.ajax(
						{
							showLoader: true,
							url: global_adminnote_deleteurl,
							type: "POST",
							data:{note_id:note_id}
						}
					).done(
						function (data) {
							return true;
						}
					);
					$(this).parents(".adminnote-container").slideUp();
				}
			}
		).on(
			"click",'#edit-note-page', function () {
				var note_id = $(this).siblings('#id-note-page').val();
				$(this).parents('.notification-global').children('.adminnote-note-content').hide();
				$(this).parents('.notification-global').children('.adminnote-note-edit').show();

			}
		).on(
			"click",'#note-edit-cancel', function () {
				$(this).parents('.notification-global').children('.adminnote-note-content').show();
				$(this).parents('.notification-global').children('.adminnote-note-edit').hide();

			}
		).on(
			"click",'#note-update', function () {
				var note_id = $(this).parents('.notification-global').find('#id-note-page').val();
				var parent = $(this).parents('.adminnote-note-edit');
				var content = parent.find('.note-page-text').val();
				var type = parent.find('.note-page-type').val();
				var title = parent.find('.note-page-type').children("option:selected").text();
				var user_id = parent.find('.user-admin-id').val();
				$.ajax(
					{
						showLoader: true,
						url: global_adminnote_saveurl,
						type: "POST",
						data:{note_id:note_id, note: content, type: type, title: title, user_id: user_id}
					}
				).done(
					function (data) {
						if (data.error) {
							$(".notification-global[name = "+note_id + "]").find('.longnote').text(content)
							$(".notification-global[name = "+note_id + "]").find('.label').text(title)
						}
						return true;
					}
				);

				$(this).parents('.notification-global').children('.adminnote-note-content').show();
				$(this).parents('.notification-global').children('.adminnote-note-edit').hide();

			}
		).on(
			"click", '#hide-note-page, #unhide-note-page', function () {
				var note_id = $(this).parents('.notification-global').find('#id-note-page').val();
				var user_id = $(this).parents('.notification-global').find('.user-admin-id').val();
				var status = $(this).attr('name');
				var e = $(".notification-global[name = " + note_id + "]");
				var hidden_count = $('#hidden-notes-count');
				$.ajax(
					{
						showLoader: true,
						url: global_adminnote_statusurl,
						type: "POST",
						data:{note_id:note_id, status: status, user_id: user_id}
					}
				).done(
					function (data) {
						if(data.error) {
							if(status == 1) {
								$('#show-hidden-notes-button').show();
								global_adminnote_hidden_count++;
								hidden_count.text(global_adminnote_hidden_count);
								e.addClass('adminnote-hidden');
								e.find('#hide-note-page').hide();
								e.find('#unhide-note-page').show();
								return true;
							}
							global_adminnote_hidden_count--;
							if(global_adminnote_hidden_count < 0) {
								global_adminnote_hidden_count = 0;
							}
							e.removeClass('adminnote-hidden');
							e.find('#hide-note-page').show();
							e.find('#unhide-note-page').hide();
						}
						return true;
					}
				);

			}
		).on(
			"click", "#show-hidden-notes-button", function () {
				$('#show-hidden-notes-button').hide();
				global_adminnote_hidden_count = 0;

				$('.adminnote-hidden').each(
					function () {
						$(this).removeClass('adminnote-hidden');
						$(this).find('#hide-note-page').hide();
						$(this).find('#unhide-note-page').show();
					}
				)
			}
		)
	}
);
