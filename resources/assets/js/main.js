const IMAGE_FILTER = ['image/jpg', 'image/jpeg', 'image/png', 'image/bmp', 'image/gif'];
const VIDEO_FILTER = ['video/mp4', 'video/webm', 'video/ogg'];

function mainInit() {
	blockPage();
    changePageTitle();
	initDatatables();
	initSelect();
	initSwitch();
	initDateTimeRangePickers();
	initChartDatePicker();
	initSummernote();
	fixInputColor();
	initMaxlength();
	initRepeaters();
	addFormHandlers('form-notify');
	unblockPage();
	updateCharts();
	displayErrors('error-messages');
	lazyLoadMedia('lazy-load');
}

function changePageTitle() {
    const elem = document.getElementById('page-title');
    if (!elem) return;

    document.title += ' | ' + elem.textContent.trim();
}
function confirmAlert() {
	return swal({
		titleText: 'Are you sure?',
		type: 'warning',
		showCancelButton: true,
		showCloseButton: true,
		buttonsStyling: false,
		confirmButtonText: '<span><i class="fa fa-check"></i> <span>Ok</span></span>',
		confirmButtonClass: 'btn m-btn btn-primary m-btn--icon',
		cancelButtonText: '<span><i class="fa fa-times"></i> <span>Cancel</span></span>',
		cancelButtonClass: 'btn m-btn btn-secondary m-btn--icon'
	});
}

function successAlert() {
	return swal({
		titleText: 'Success!',
		type: 'success',
		timer: 3000,
		showCloseButton: true,
		buttonsStyling: false,
		confirmButtonText: '<span><i class="fa fa-check"></i> <span>Ok</span></span>',
		confirmButtonClass: 'btn m-btn btn-success m-btn--icon'
	});
}

function initMaxlength() {
	return $('input[maxlength], textarea[maxlength]').maxlength({
		alwaysShow: true,
		warningClass: 'm-badge m-badge--primary m-badge--rounded m-badge--wide',
		limitReachedClass: 'm-badge m-badge--danger m-badge--rounded m-badge--wide'
	});
}

function initRepeaters(selector = '.repeater') {
	return $(selector).repeater({
		initEmpty: false,
		isFirstItemUndeletable: false,
		show: function() {
			$(this).slideDown();
			initMaxlength();
		},
		hide: function(e) {
			$(this).slideUp(e);
		}
	});
}

function initSwitch() {
	return $('[data-switch=true]').bootstrapSwitch();
}

function initSelect() {
	return $('select.m-bootstrap-select').selectpicker();
}

function initSummernote() {
	return $('.summernote').summernote({
		dialogsFade: true,
		callbacks: {
			onChange: function(contents) {
				if (this.dataset.textarea)
					document.getElementById(this.dataset.textarea).value = contents.trim();
			}
		}
	});
}

function fixInputColor() {
	return $('input[type=color]').css('height', '36px');
}

function initDatatables() {
    return $('table.js-datatable').DataTable({
        order: [],
        processing: true,
        colReorder: true,
        pagingType: 'full_numbers',
        pageLength: 50,
        lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'All']],
        dom:
            "<'row'<'col-sm-4 text-left'f><'col-sm-4 text-left dataTables_pager'lp><'col-sm-4 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                autoClose: true,
                buttons: [
                    'copyHtml5',
                    'print',
                    'csvHtml5',
                    'excelHtml5',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape'
                    },
                    {
                        text: 'JSON',
                        action: function(e, dt) {
                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(dt.buttons.exportData())], { type: 'application/json' }),
                                document.title + '.json'
                            );
                        }
                    }
                ]
            },
            {
                extend: 'collection',
                text: 'Visibility',
                buttons: ['colvisRestore', 'colvis']
            }
        ]
    });
}

function showMedia(elem, galleryDiv) {
	galleryDiv = document.getElementById(galleryDiv);
	galleryDiv.innerHTML = '';

	var path, name, type, size, content;

	for (const file of elem.files) {
		path = window.URL.createObjectURL(file);
		type = file.type;

		if (IMAGE_FILTER.indexOf(type) > -1)
			content =
				'<a target="_blank" href="' + path + '"><img class="img-thumbnail" src="' + path + '"></a>';
		else if (VIDEO_FILTER.indexOf(type) > -1)
			content =
				'<video controls class="img-thumbnail"><source src="' +
				path +
				'" type="' +
				type +
				'"></video>';
		else continue;

		name = file.name.trim();
		size = file.size / (1024 * 1024);
		size = parseFloat(size.toFixed(2));

		galleryDiv.insertAdjacentHTML(
			'beforeend',
			'<div class="col-sm-2">' + content + '<p>' + name + ' (' + size + ' MB)</p></div>'
		);
	}
}

function lazyLoadMedia(class_name) {
	const elems = $('.' + class_name + '[data-src]');
	for (const elem of elems) elem.src = elem.dataset.src.trim();
}

function addFormHandlers(class_name) {
	const elems = document.querySelectorAll('form.' + class_name);

	for (const elem of elems) {
		elem.onreset = () => {
			const galleries = elem.querySelectorAll('.gallery-container');
			for (const gallery of galleries) gallery.innerHTML = '';
		};

		elem.onsubmit = () => {
			fireNotification({
				message: 'Saving data in progress...',
				icon: 'fa fa-spinner fa-spin',
				type: 'success',
				delay: 0
			});

			const buttons = document.querySelectorAll('button[type="submit"][form="' + elem.id + '"]');

			for (const button of buttons) {
				button.disabled = true;
				button.classList.add('m-loader', 'm-loader--light', 'm-loader--right');
			}
		};
	}
}

function blockPage() {
	return mApp.blockPage({
		overlayColor: '#000000',
		type: 'loader',
		state: 'success',
		message: 'Please wait...'
	});
}

function unblockPage() {
	return mApp.unblockPage();
}

function blockSection(selector) {
	return mApp.block(selector, {
		overlayColor: '#000000',
		type: 'loader',
		state: 'primary'
	});
}

function unblockSection(selector) {
	return mApp.unblock(selector);
}

function blockModal(modal) {
	return blockSection('#' + modal + ' .modal-content');
}

function unblockModal(modal) {
	return unblockSection('#' + modal + ' .modal-content');
}

function initDateTimeRangePickers() {
	return $('.datetimerangepicker').daterangepicker(
		{
			buttonClasses: 'm-btn btn',
			applyClass: 'btn-primary',
			cancelClass: 'btn-secondary',
			timePicker: true,
			timePicker24Hour: true,
			showWeekNumbers: true,
			autoUpdateInput: true,
			minDate: new Date(),
			locale: { format: 'DD/MM/YYYY HH:mm' }
		},
		function(a, b) {
			const id = $(this)
				.attr('element')
				.attr('id');

			$('#' + id + '-first').val(a.format('YYYY-MM-DD HH:mm:ss'));
			$('#' + id + '-second').val(b.format('YYYY-MM-DD HH:mm:ss'));
		}
	);
}

function fireNotification(data) {
	return $.notify(
		{
			// options
			message: data.message,
			icon: 'icon ' + data.icon
		},
		{
			// settings
			type: data.type,
			delay: data.delay * 1000
		}
	);
}

function utcToLocal(timestamp) {
	return moment.utc(timestamp).local();
}

function localTimestamp(timestamp, format = 'DD/MM/YYYY HH:mm') {
	return utcToLocal(timestamp).format(format);
}

function fromNowTimestamp(timestamp) {
	return utcToLocal(timestamp).fromNow();
}

function toggleCheckboxes(state, class_name) {
	const inputs = document.querySelectorAll('input.' + class_name);
	for (const input of inputs) input.checked = state;
}

function gatherFormInputs(form_elem) {
	return confirmAlert().then(e => {
		if (!e.value) return;

		fireNotification({
			message: 'Saving data in progress...',
			icon: 'fa fa-spinner fa-spin',
			type: 'success',
			delay: 0
		});

		const inputs = document.querySelectorAll('input.options-form:checked');
		for (const input of inputs) input.setAttribute('form', form_elem.id);

		form_elem.submit();
	});
}

function displayErrors(elem_id) {
	const errors = JSON.parse(document.getElementById(elem_id).innerHTML.trim());

	for (const error of errors) {
		fireNotification({
			message: error,
			icon: 'fa fa-exclamation-triangle',
			type: 'danger',
			delay: 5
		});
	}
}
