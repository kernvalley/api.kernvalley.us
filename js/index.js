import 'https://shgysk8zer0.github.io/js/std-js/deprefixer.js';
import 'https://shgysk8zer0.github.io/js/std-js/shims.js';
import {ready, $} from 'https://shgysk8zer0.github.io/js/std-js/functions.js';
import {getImagePreviewURI} from './funcs.js';
import * as forms from './forms.js';

ready().then(() => {
	document.getElementById('preview').append(document.getElementById('ad-template').content.cloneNode(true));

	$('[name="background-image"]').change(async event => {
		try {
			const uris = await getImagePreviewURI(event.target);
			$('#preview .ad').css({
				'background-image': `url(${uris[0]})`,
			});
		} catch (err) {
			console.error(err);
			alert(err);
		}
	}, {passive: true});

	$('[name="logo"]').change(async event => {
		try {
			const uris = await getImagePreviewURI(event.target);
			$('#preview [data-field="logo"]').attr({src: uris[0]});
		} catch (err) {
			console.error(err);
			alert(err);
		}
	}, {passive: true});

	$('[name="background-color"]').input(event => {
		$('#preview .ad').css({
			'background-color': event.target.value,
		});
	}, {passive: true});

	$('[name="title"]').input(event => {
		$('#preview [data-field="title"]').text(event.target.value);
	}, {passive: true});

	$('[name="telephone"]').input(event => {
		$('#preview [data-field="telephone"]').text(event.target.value);
	}, {passive: true});

	$('[name="email"]').input(event => {
		$('#preview [data-field="email"]').text(event.target.value);
	}, {passive: true});

	/*$('[name="width"]').input(event => {
		$('#preview .ad').css({width: `${event.target.value}px`});
	}, {passive: true});

	$('[name="height"]').input(event => {
		$('#preview .ad').css({height: `${event.target.value}px`});
	}, {passive: true});*/

	$('[name="content"]').input(event => {
		$('#preview [data-field="content"]').text(event.target.value);
	}, {passive: true});

	$('[name="color"]').input(event => {
		$('#preview .ad').css({color: event.target.value});
	}, {passive: true});

	$('[name="background-x"]').input(event => {
		$('#preview .ad').css({'background-position-x': `${event.target.value}%`});
	}, {passive: true});

	$('[name="background-y"]').input(event => {
		$('#preview .ad').css({'background-position-y': `${event.target.value}%`});
	}, {passive: true});

	$('form[name="api"]').submit(forms.api)
	$('form[name="ad"]').reset(() => {
		const preview = document.querySelector('#preview .ad');
		const template = document.getElementById('ad-template').content.cloneNode(true);
		preview.replaceWith(template);
	});

	$('form[name="ad"]').submit(forms.ad);

	$('form[name="registration"]').submit(forms.registration);

	$('#api-dialog').on('close', event => {
		$('.api-header, .api-param', event.target).remove();
	});

	$('[data-close]').click(event => {
		$(event.target.dataset.close).close();
	});

	$('[data-show-modal]').click(event => {
		$(event.target.dataset.showModal).showModal();
	});

	$('[data-add="header"]').click(() => {
		const template = document.getElementById('api-header-template').content.cloneNode(true);
		const container = document.getElementById('headers-list');
		$('[data-remove="header"]', template).click(event => {
			event.target.closest('.api-header').remove();
		});
		container.append(template);
		container.querySelector('.header-key').focus();
	});

	$('[data-add="param"]').click(() => {
		const template = document.getElementById('api-param-template').content.cloneNode(true);
		const container = document.getElementById('params-list');
		$('[data-remove="param"]', template).click(event => {
			event.target.closest('.api-param').remove();
		});
		container.append(template);
		container.querySelector('.param-key').focus();
	});

	[...document.forms].forEach(form => form.reset());
});
