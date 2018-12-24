document.addEventListener('DOMContentLoaded', () => {
	'use strict';

	// Accounts AJAX
	for (var i = 0; i < document.querySelectorAll('#account-delete').length; i++) {
		document.querySelectorAll('#account-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/account.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'account=' + e.target.getAttribute('data-account')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	document.getElementById('account-add').addEventListener('click', () => {
		fetch('inc/actions/account.add.inc.php', {
			method: 'post',
			headers: {
				'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'username=' + document.getElementById('account-username').value + '&password=' + document.getElementById('account-password').value + '&email=' + document.getElementById('account-email').value + '&position=' + document.getElementById('account-position').value
		}).then(function(response) {
			if (response.status == 200) {
				let HTMLTableRowElement_NewRow = document.createElement('tr');

				let Username = document.getElementById('account-username').value;
				let Email = document.getElementById('account-email').value;
				let Company = document.getElementById('account-add').getAttribute('data-company');
				let Position = document.getElementById('account-position').value;

				HTMLTableRowElement_NewRow.innerHTML = `<td>${Username}</td><td>${Email}</td><td>${Company}</td><td>${Position}</td><td id="account-delete" class="option delete" data-account="${Username}">Delete</td>`;

				if (Username != '' && Email != '' && Company != '' && Position != '') {
					document.querySelector('#account-add').parentElement.parentElement.prepend(HTMLTableRowElement_NewRow);
				}

				/**
                 * We need to run this again over all newly added entries
				 * TODO Revisit Revisit this later to see if we can do this a better way
                 */

				for (var i = 0; i < document.querySelectorAll('#account-delete').length; i++) {
					document.querySelectorAll('#account-delete')[i].addEventListener('click', (e) => {
						fetch('inc/actions/account.delete.inc.php', {
							method: 'post',
							headers: {
								'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
							},
							body: 'account=' + e.target.getAttribute('data-account')
						}).then(function(response) {
							if (response.status == 200) {
								e.target.parentElement.remove();
							}
						});
					});
				}
			}
		});
	});

	// Days AJAX
	document.getElementById('day-add').addEventListener('click', () => {
		fetch('inc/actions/day.add.inc.php', {
			method: 'post',
			headers: {
				'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'day=' + document.getElementById('day-day').value
		}).then(function(response) {
			if (response.status == 200) {
				let HTMLTableRowElement_NewRow = document.createElement('tr');

				let Day = document.getElementById('day-day').value;

				HTMLTableRowElement_NewRow.innerHTML = `<td>${Day}</td><td id="account-delete" class="option delete" data-day="${Day}">Delete</td>`;

				if (Day != '') {
					document.querySelector('#day-add').parentElement.parentElement.prepend(HTMLTableRowElement_NewRow);
				}

				/**
                 * We need to run this again over all newly added entries
				 * TODO Revisit Revisit this later to see if we can do this a better way
                 */

				for (var i = 0; i < document.querySelectorAll('#day-delete').length; i++) {
					document.querySelectorAll('#day-delete')[i].addEventListener('click', (e) => {
						fetch('inc/actions/day.delete.inc.php', {
							method: 'post',
							headers: {
								'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
							},
							body: 'day=' + e.target.getAttribute('data-day')
						}).then(function(response) {
							if (response.status == 200) {
								e.target.parentElement.remove();
							}
						});
					});
				}
			}
		});
	});

	for (var i = 0; i < document.querySelectorAll('#day-delete').length; i++) {
		document.querySelectorAll('#day-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/day.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'day=' + e.target.getAttribute('data-day')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	// Leave AJAX
	for (var i = 0; i < document.querySelectorAll('#leave-delete').length; i++) {
		document.querySelectorAll('#leave-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/leave.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'start=' + e.target.getAttribute('data-start') + '&end=' + e.target.getAttribute('data-end')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	// Locations AJAX
	for (var i = 0; i < document.querySelectorAll('#location-delete').length; i++) {
		document.querySelectorAll('#location-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/location.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'location=' + e.target.getAttribute('data-location')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	document.getElementById('location-add').addEventListener('click', () => {
		fetch('inc/actions/location.add.inc.php', {
			method: 'post',
			headers: {
				'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'location=' + document.getElementById('location-name').value
		}).then(function(response) {
			if (response.status == 200) {
				let HTMLTableRowElement_NewRow = document.createElement('tr');

				let Location = document.getElementById('location-name').value;

				HTMLTableRowElement_NewRow.innerHTML = `<td>${Location}</td><td id="location-delete" class="option delete" data-location="${Location}">Delete</td>`;

				if (Location != '') {
					document.querySelector('#location-add').parentElement.parentElement.prepend(HTMLTableRowElement_NewRow);
				}

				/**
                 * We need to run this again over all newly added entries
				 * TODO Revisit Revisit this later to see if we can do this a better way
                 */

				for (var i = 0; i < document.querySelectorAll('#location-delete').length; i++) {
					document.querySelectorAll('#location-delete')[i].addEventListener('click', (e) => {
						fetch('inc/actions/location.delete.inc.php', {
							method: 'post',
							headers: {
								'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
							},
							body: 'location=' + e.target.getAttribute('data-location')
						}).then(function(response) {
							if (response.status == 200) {
								e.target.parentElement.remove();
							}
						});
					});
				}
			}
		});
	});

	// Positions AJAX
	for (var i = 0; i < document.querySelectorAll('#position-delete').length; i++) {
		document.querySelectorAll('#position-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/position.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'position=' + e.target.getAttribute('data-position')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	document.getElementById('position-add').addEventListener('click', () => {
		fetch('inc/actions/position.add.inc.php', {
			method: 'post',
			headers: {
				'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'position=' + document.getElementById('position-name').value + '&admin=' + document.getElementById('position-admin').value
		}).then(function(response) {
			if (response.status == 200) {
				let HTMLTableRowElement_NewRow = document.createElement('tr');

				let Position = document.getElementById('position-name').value;
				let Admin = document.getElementById('position-admin').value;

				switch (Admin) {
					case 'on':
						Admin = 'Admin';
						break;
					case 'off':
						Admin = 'N/A';
						break;
					default:
						Admin = 'N/A';
						break;
				}

				HTMLTableRowElement_NewRow.innerHTML = `<td>${Position}</td><td>${Admin}</td><td id="position-delete" class="option delete" data-position="${Position}">Delete</td>`;

				if (Position != '' && Admin != '') {
					document.querySelector('#position-add').parentElement.parentElement.prepend(HTMLTableRowElement_NewRow);
				}

				/**
                 * We need to run this again over all newly added entries
				 * TODO Revisit Revisit this later to see if we can do this a better way
                 */

				for (var i = 0; i < document.querySelectorAll('#position-delete').length; i++) {
					document.querySelectorAll('#position-delete')[i].addEventListener('click', (e) => {
						fetch('inc/actions/position.delete.inc.php', {
							method: 'post',
							headers: {
								'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
							},
							body: 'position=' + e.target.getAttribute('data-position')
						}).then(function(response) {
							if (response.status == 200) {
								e.target.parentElement.remove();
							}
						});
					});
				}
			}
		});
	});

	// News AJAX
	for (var i = 0; i < document.querySelectorAll('#news-delete').length; i++) {
		document.querySelectorAll('#news-delete')[i].addEventListener('click', (e) => {
			fetch('inc/actions/news.delete.inc.php', {
				method: 'post',
				headers: {
					'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
				},
				body: 'newsid=' + e.target.getAttribute('data-newsid')
			}).then(function(response) {
				if (response.status == 200) {
					e.target.parentElement.remove();
				}
			});
		});
	}

	document.getElementById('news-submit').addEventListener('click', (e) => {
		fetch('inc/actions/news.add.inc.php', {
			method: 'post',
			headers: {
				'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'author=' + e.target.getAttribute('data-author') + '&title=' + document.getElementById('news-title').value + '&content=' + document.getElementById('news-content').value
		}).then(function(response) {
			if (response.status == 200) {
				let HTMLTableRowElement_NewRow = document.createElement('tr');

				var DateObj = new Date();

				let Author = e.target.getAttribute('data-author');
				let Title = document.getElementById('news-title').value;

				HTMLTableRowElement_NewRow.innerHTML = `<td>${Author}</td><td>${DateObj.getDay()}/${DateObj.getMonth()}/${DateObj.getFullYear()}</td><td>${Title}</td><td id="news-delete" class="option delete" data-title="${Title}">Delete</td>`;

				if (Author != '' && Title != '') {
					document.getElementById('table-container').firstChild.nextSibling.appendChild(HTMLTableRowElement_NewRow);
				}

				/**
                 * We need to run this again over all newly added entries
				 * TODO Revisit Revisit this later to see if we can do this a better way
                 */

				for (var i = 0; i < document.querySelectorAll('#news-delete').length; i++) {
					document.querySelectorAll('#news-delete')[i].addEventListener('click', (e) => {
						fetch('inc/actions/news.delete.inc.php', {
							method: 'post',
							headers: {
								'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
							},
							body: 'newsid=' + e.target.getAttribute('data-newsid')
						}).then(function(response) {
							if (response.status == 200) {
								e.target.parentElement.remove();
							}
						});
					});
				}
			}
		});
	});
});
