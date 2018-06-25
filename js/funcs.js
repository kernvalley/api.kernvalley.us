import {$} from 'https://shgysk8zer0.github.io/js/std-js/functions.js';

export async function readFile(file, as = 'data') {
	return await new Promise((resolve, reject) => {
		const reader = new FileReader();
		reader.onload = event => resolve(event.target.result);
		reader.onerror = event => reject(event.target);

		switch (as) {
			case 'text':
				reader.readAsText(file);
				break;
			case 'binary':
				reader.readAsBinary(file);
				break;
			case 'buffer':
				reader.readAsArrayBuffer(file);
				break;
			case 'data':
			default:
				reader.readAsDataURL(file);
		}
	});
}

export async function getImagePreviewURI(input) {
	const supportedTypes = [
		'image/jpeg',
		'image/png',
		'image/svg+xml',
	];

	if (input.files) {
		const files = [...input.files].filter(file => supportedTypes.includes(file.type));
		return await Promise.all(files.map(async file => {
			let uri = '';
			switch (file.type) {
				case 'image/svg+xml':
					const svg = await readFile(file, 'text');
					uri = `data:image/svg+xml,${encodeURIComponent(svg)}`;
					break;
				case 'image/png':
				case 'image/jpeg':
					uri = await readFile(file, 'data');
					break;
				default:
					throw new TypeError(`Unsupported file type: "${file.type}"`);
			}
			return uri;
		}));
	} else {
		throw new Error('input.files is empty');
	}
}
