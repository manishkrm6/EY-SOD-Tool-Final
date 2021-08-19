<!-- Begin Modal -->
  <div class="modal" id="uploadInterfaceModal">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- upload from file Modal Header -->
          <div class="modal-header">
          <p class="modal-title">Upload Data</p>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">  
          <form>
             
            <!--upload from file css popup-->
            <style type="text/css">.upload-btn-wrapper {
                  position: relative;
                  overflow: hidden;
                  display: inline-block;
                  min-width: 100%;
                  background-color: ;

                }

                .btnup   {
                  border: px solid gray;
                  color: gray;
                  background-color: white;
                  padding: 8px 10px;
                  border-radius: 8px;
                  font-size: 13px;
                  font-weight: bold;
                  line-height: 10px;
                   min-width: 100%;
                  background-color: #FFE600;  
                  color: black;
                }

                .upload-btn-wrapper input[type=file] {
                  font-size: 100px;
                  position: absolute;
                  left: 0;
                  top: 0;
                  opacity: 0;
                }

                .btnbrose{
                  border: px solid gray;
                  color: gray;
                  background-color: white;
                  padding: 8px 10px;
                  border-radius: 8px;
                  font-size: 13px;
                  font-weight: bold;
                  line-height: 10px;
                   min-width: 100%;
                  background-color:#E8E8E8;  
                  color: black;
                }
        </style> <!--upload from file css popup css end-->

              <!--upload from file code start here-->
              <div class="upload-btn-wrapper customgrey">
                  <button type="button" class="btn btnup mb-4" data-toggle="modal" data-target="#sapConnectionModal">Choose SAP Connection</button>
                 <!--  <input type="text" name="myfile" /> -->
              </div>

              <h5 class="text-center" style="margin-top: -9px">Or</h5>
               <div class="upload-btn-wrapper customgrey">
                  <button type="button" class="btn btnbrose"data-toggle="modal" data-target="#browseForUploadModal">Browse Upload</button>
              </div>
            </form>
          </div>      
        </div>
      </div>
    </div>
<!-- end upload from file Modal code -->