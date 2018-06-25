import {$} from 'https://shgysk8zer0.github.io/js/std-js/functions.js';

const ads = document.getElementById('ads');

export async function api(event) {
	event.preventDefault();

	const url = new URL(event.target.querySelector('[name="url"]').value);
	const method = event.target.querySelector('[name="method"]').value;
	const headers = new Headers();
	const mode = 'cors';
	const body = !['GET', 'HEAD'].includes(method)
		? new FormData()
		: url.searchParams;

	await Promise.all([
		$('.api-param', event.target).each(el => {
			const key = el.querySelector('[name="param-key[]"]').value;
			const value = el.querySelector('[name="param-value[]"]').value;
			body.append(key, value);
		}),
		$('.api-header', event.target).each(el => {
			const key = el.querySelector('[name="header-key[]"]').value;
			const value = el.querySelector('[name="header-value[]"]').value;
			headers.append(key, value);
		})
	]);

	if (body instanceof FormData) {
		fetch(url, {method, headers, body, mode});
	} else {
		fetch(url, {method, headers, mode});
	}
}

export async function ad(event) {
	event.preventDefault();
	const url = new URL(event.target.action, document.baseURI);
	const body = new FormData(event.target);
	const headers = new Headers();
	headers.set('Accept', 'application/json');

	const resp = await fetch(url, {
		method: 'POST',
		body,
		headers,
	});

	if (resp.ok) {
		const ad = await resp.json();
		const template= document.getElementById(ad.template).content.cloneNode(true);

		await Promise.all([
			$('[data-field="title"]', template).text(ad.title),
			$('[data-field="content"]', template).text(ad.content),
			$('[data-field="logo"]', template).attr({src: `${new URL(ad.logo.path, document.baseURI)}`}),
			$('[data-field="logo"]', template).addClass(ad.logo.animation),
			$('[data-field="link"]', template).attr({href: ad.link}),
			$('[data-field="email"]', template).text(ad.email),
			$('[data-field="email-link"]', template).attr({href:`mailto:${ad.email}`}),
			$('[data-field="telephone"]', template).text(ad.telephone),
			$('[data-field="telephone-link"]', template).attr({href: `tel:${ad.telephone}`}),
			$(template.children).css({
				'background-color': ad.backgroundColor,
				'background-image': ad.hasOwnProperty('backgroundImage')
					? `url(${new URL(ad.backgroundImage.path, document.baseURI)})`
					: 'none',
				'background-position-x': `${ad.backgroundX}%`,
				'background-position-y': `${ad.backgroundY}%`,
				color: ad.color,
			}),
		]);

		if (body.has('clear-ads')) {
			await $(ads.children).remove();
		}

		ads.append(template);

		event.target.closest('dialog').close();
		event.target.reset();
	}
}

export async function registration(event) {
	event.preventDefault();
	const body = new FormData(event.target);
	const url = new URL(event.target.action, document.baseURI);
	const headers = new Headers();

	headers.set('Accept', 'application/json');

	const resp = await fetch(url, {
		method: 'POST',
		headers,
		body,
	});

	if (resp.ok) {
		const json = await resp.json();
		const template = document.getElementById('user-template').content.cloneNode(true);
		const users = document.getElementById('users');

		await Promise.all([
			$('[data-field="mail-link"]', template).each(el => {
				el.href = `mailto:${json.Person.email}`;
			}),
			$('[data-field="avatar"]', template).each(el => {
				el.src = json.Person.gravatar;
			}),
			$('[data-field="name"]', template).each(el => {
				el.textContent = json.Person.name;
			}),
		]);

		users.append(template);
		event.target.closest('dialog').close();
		event.target.reset();
	}
}
