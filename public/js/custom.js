$("#multiplefileupload").fileinput({
        'theme': 'fa',
        'uploadUrl': '#',
        showRemove: false,
        showUpload: false,
        showZoom: false,
        showCaption: false,
        browseClass: "btn btn-danger",
        browseLabel: "",
        browseIcon: "<i class='fa fa-plus'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        fileActionSettings :{
        	showUpload: false,
        	showZoom: false,
          removeIcon: "<i class='fa fa-times'></i>",
        }
    });