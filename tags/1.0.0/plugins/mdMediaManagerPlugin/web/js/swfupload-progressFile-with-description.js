function FileProgress(file, targetID) {
    this.fileId = file.id;
	this.fileProgressID = 'image-progress' + this.fileId;

    this.fileProgressWrapper = document.getElementById(this.fileProgressID);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.fileProgressID;

		this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

        var progressThumbnail = document.createElement("div");
        progressThumbnail.setAttribute('style', 'float:left; margin-top:5px;');

        var progressThumbnailImage = document.createElement('img');
        progressThumbnailImage.src = "";
        progressThumbnailImage.id = "img_"+ this.fileId;
        progressThumbnailImage.setAttribute('style','width: 56px; height:56px;');
        progressThumbnail.appendChild(progressThumbnailImage);

        var progressCancel = document.createElement("a");
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressText = document.createElement("div");
		progressText.className = "progressName";

        var divContent = document.createElement("div");

        divContent.innerHTML = "<form action='/backend.php/uploader/updateImageDescription' name='form_desc' id='form_desc' class='form_desc' ><input style='display:none;' type='text' name='description' onblur='saveImageDescription(this)'><input type='hidden' name='imageId' /></form>"

        progressText.appendChild(divContent);

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

        var progressBarPercentage = document.createElement("div");

        var albumSelectorDiv = document.createElement('div');
        albumSelectorDiv.style.display = 'none';
        albumSelectorDiv.innerHTML = combo_select_album;

        this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressText);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);
        this.fileProgressElement.appendChild(progressBarPercentage);
        this.fileProgressElement.appendChild(albumSelectorDiv);

        this.fileProgressWrapper.appendChild(progressThumbnail);
		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		document.getElementById(targetID).appendChild(this.fileProgressWrapper);
		//fadeIn(this.fileProgressWrapper, 0);

	} else {
        this.fileProgressElement = this.fileProgressWrapper.childNodes[1];
		//this.fileProgressElement.childNodes[1].firstChild.nodeValue = file.name;
	}

	this.height = this.fileProgressWrapper.offsetHeight;

}
FileProgress.prototype.setProgress = function (percentage) {
    this.fileProgressElement.className = "progressContainer green";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";//"progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = (percentage >= 90)? (percentage - 12) + "%": percentage + "%";
    this.fileProgressElement.childNodes[4].innerHTML = percentage + "%";
};
FileProgress.prototype.setComplete = function () {
	this.fileProgressElement.className = "progressContainer blue";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";
	//this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setError = function () {
	this.fileProgressElement.className = "progressContainer red";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};

FileProgress.prototype.setServerData = function (server_data) {
    var paramsSplit = server_data.split('|');
    document.getElementById("img_" + this.fileId).src = (paramsSplit[0]);
    try{
        this.fileProgressElement.childNodes[1].childNodes[0].childNodes[0].childNodes[1].value = paramsSplit[1];
        this.fileProgressElement.childNodes[1].childNodes[0].childNodes[0].childNodes[0].style.display = 'block';

        this.fileProgressElement.childNodes[5].style.display = 'block';
        this.fileProgressElement.childNodes[5].childNodes[0].onchange = function(){ saveImageToAlbum(this, paramsSplit[1]) };


        top.afterReceiveServerData(paramsSplit[1]);
    }catch(e){
        //alert(e);
    }
};

FileProgress.prototype.setCancelled = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setStatus = function (status) {
	this.fileProgressElement.childNodes[2].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function (show, swfuploadInstance) {
	//this.fileProgressElement.childNodes[1].style.visibility = show ? "visible" : "hidden";
	if (swfuploadInstance) {
		var fileID = this.fileProgressID;
		this.fileProgressElement.childNodes[1].onclick = function () {
			swfuploadInstance.cancelUpload(fileID);
			return false;
		};
	}
};

function fadeIn(element, opacity) {
	var reduceOpacityBy = 5;
	var rate = 30;	// 15 fps


	if (opacity < 100) {
		opacity += reduceOpacityBy;
		if (opacity > 100) {
			opacity = 100;
		}

		if (element.filters) {
			try {
				element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function () {
			fadeIn(element, opacity);
		}, rate);
	}
}


function saveImageDescription(obj){

    $(obj).up('.form_desc').request({
        onSuccess: function(response){
        }
    });
}

function saveImageToAlbum(selectObj, imageId){
    var albumId = selectObj.options[selectObj.selectedIndex].value;
    var url = '/backend.php/uploader/updateImageAlbum';
    var myAjax = new Ajax.Request(url, {
       
       parameters: 'imageId='+imageId+'&albumId='+albumId,
       onSuccess: function(response){

       }
    });
}