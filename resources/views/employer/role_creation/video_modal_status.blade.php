<div class="row">
    <style>
        .progressContainer {display: none;}
        #pmvCameraModalNew .modal-video-modal{height: 100%!important; min-height: 360px}
        .statusBar{background-color: #FFF; padding-bottom: 15px}
        .progressBarOutside {border: 1px solid #333; height: 25px; background-color: #FFF}
        .progressbar {height: 23px; background-color: #00afed; text-align: right; color: #FFF;width: 0px; padding-right: 15px}
        .preparing, .errorUpload, .successUpload, .finalize {display: none}
    </style>
    <div class="col-sm-12 statusBar text-center">
        
        <div class="preparing">
            Preparing upload. Please wait...<br>
            <strong>Please do not refresh or close this page</strong>
        </div>
        <div class="finalize">
            Finalizing upload. Please wait...<br>
            <strong>Please do not refresh or close this page </strong>
        </div>
        <div class="progressContainer">
            <div class="text">Uploading. Please do not refresh or close this page </div>
            <div class="progressBarOutside">
                <div class="progressbar"> <span></span></div>
            </div>
        </div>
         
        <div class="errorUpload alert alert-danger"  >
            <div class="text">Failed with error: <span></span></div>
        </div>

        <div class="successUpload alert alert-success"  >
            <div class="text"><strong>Successful.</strong> The video will be encoded before it can be viewed.</div>
        </div>
    </div>
</div>