(function(){

    var container = document.getElementById("slide-container");
    var carousel = document.getElementById("slide-carousel");
    var next_btn = document.getElementById("next_btn");
    var prev_btn = document.getElementById("prev_btn");
    var url = "https://api.github.com/users";
    var current = 0;
    var imageLength = 0;
    var timer = null;
	var images = [];
	var userLogins = [];

	if (!users || users.length == 0) {
        imageLoader(url, onload);
    }
    else {
    	images = users;
    	onload();
	}
    next_btn.addEventListener("click",next);
    prev_btn.addEventListener("click",previous);


    function next() {
        current ++;
        slideUpdate();
    }
    
    function previous() {
        current --;
        slideUpdate();
    }

    function slideUpdate(reset) {
		if (reset) {
			current = 0;
		}
        clearTimeout(timer);
        timer = setTimeout(next,3000);
        if (current > imageLength-3) {
            carousel.style.transition = 'left 0s ease-in';
            carousel.style.left = 0 + 'px';
            carousel.offsetHeight;
            carousel.style.transition = '';
            current = 0;
        }
        if (current < 0) {
            carousel.style.transition = 'left 0s ease-in';
            carousel.style.left = ((imageLength-1) * -400) + 'px';
            carousel.offsetHeight;
            carousel.style.transition = '';
            current =imageLength-2;
        }
        var offset = (current+1) * -400;
		if (reset) {
			carousel.style.transition = 'left 0s ease-in';
			carousel.style.left = offset+'px';
			carousel.offsetHeight;
			carousel.style.transition = '';
		} else {
        	carousel.style.left = offset+'px';
		}
    }

    function imageLoader(url, onload) {
        ajaxGet(url, function(responseText) {
            var data = JSON.parse(responseText);
            for (var i = 0; i < data.length; i++) {
				images.push({
					avatar: data[i].avatar_url,
					isAdmin: data[i].site_admin,
					login: data[i].login
				})
            }
            onload();
        })
    }


	function createRequest(callback) {
		var request;
        if(window.XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else if(window.ActiveXObject) {
            request = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            return;
        }

        request.onreadystatechange = function() {
            if (request.readyState === XMLHttpRequest.DONE) {
				if (request.status === 200) {
	                callback(request.responseText);
				}
            }
        }
        return request;
	}

    function ajaxGet(url, callback) {
        var request = createRequest(callback);
        request.open('GET', url, true);
        request.send('');
    }
    
	function ajaxPost(url, callback, data, transform) {
		var request = createRequest(callback);
        request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		var request_params = '';
		for (var i = 0; i < data.length; i++) {
			var item = data[i];
			if (typeof transform === 'function') {
				item = transform(item);
			}
			for (var prop in item) {
				if (request_params) {
					request_params += '&';
				}
				request_params += 'users[' + i + '][' + prop + ']=' + encodeURIComponent(item[prop]);
			}
		}
		request.send(request_params);
	}

    function onload() {
		ajaxPost(document.baseURI, function() {
			console.log('done');
		}, images);

		  imageFilter('all');
    }
    
	function searchUser() {
		var search_value = document.getElementById('search').value;
		for (var i = 0; i<userLogins.length; i++) {
			if (userLogins[i] == search_value) {
				current = i;
                slideUpdate();
			}
		}
	}

	function imageFilter(category) {
		while (carousel.firstChild) {
			carousel.removeChild(carousel.firstChild);
		}

		var first = null;
		var last = null;
		imageLength = 0;
		userLogins = [];

		for (var i = 0; i < images.length; i++) {
			var showUser = true;
			switch (category) {
				case 'admin':
					showUser = (images[i].isAdmin == true);
					break;
				case 'not_admin':
					showUser = (images[i].isAdmin == false);
					break;
			}
			if (showUser) {
				userLogins.push(images[i].login);
				var img = document.createElement("img");
				img.src=images[i].avatar;
				img.className="img";
				carousel.appendChild(img);

				if (first == null) {
					first = i;
				}
				last = i;
				imageLength++;
			}
		}

		console.log(userLogins);

		if (first != null) {
			img = document.createElement("img");
			img.src=images[first].avatar;
			img.className="img";
			carousel.appendChild(img);
		}

		if (last != null) {
			var img = document.createElement("img");
			img.src=images[last].avatar;
			img.className="img";
			carousel.insertBefore(img, carousel.firstChild);
		}
		imageLength += 2;

        slideUpdate(true);
	    return category;
	}


	function setActive(){

	}
	window.imageFilter = imageFilter;
	window.searchUser = searchUser;

})();