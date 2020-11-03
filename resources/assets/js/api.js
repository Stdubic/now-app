class ApiHandler {
	get(url, callback, data, extra) {
		return this.call('GET', url, callback, data, extra);
	}

	post(url, callback, data, extra) {
		return this.call('POST', url, callback, data, extra);
	}

	put(url, callback, data, extra) {
		return this.call('PUT', url, callback, data, extra);
	}

	patch(url, callback, data, extra) {
		return this.call('PATCH', url, callback, data, extra);
	}

	delete(url, callback, data, extra) {
		return this.call('DELETE', url, callback, data, extra);
	}

	call(method, url, callback, data, extra) {
		const headers = new Headers();
		headers.set('Accept', 'application/json');
		headers.set('Content-Type', 'application/json; charset=utf-8');

		return fetch(url, {
			method: method,
			headers: headers,
			body: data ? JSON.stringify(data) : null
		})
			.then(data => data.json())
			.then(data => {
				if (callback) callback(data, extra);
			});
	}
}

class FormHandler {
	submit(form, callback, extra) {
		const headers = new Headers();
		headers.set('Accept', 'application/json');

		return fetch(form.action, {
			method: form.method,
			headers: headers,
			body: new FormData(form)
		})
			.then(data => data.json())
			.then(data => {
				if (callback) callback(data, extra);
			});
	}
}
