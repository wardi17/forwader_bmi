import {url_store} from '../config.js';
import {pageMode} from "./main.js";
class AttachAdd {
  constructor(uploadedFiles) {
  
    this.uploadedFiles = uploadedFiles;
    this.renderData();
    const isEditMode = pageMode === "edit" || pageMode === "post" || pageMode ==="detail" || pageMode ==="lap_d";

    if(isEditMode){
      this.setdoducument();
    }
    
  }

  renderData() {
    const tampilAttach = $("#tampil_attach");

    $("#attach").on("change", (event) => {
      let files = Array.from(event.target.files);

      files.forEach((file, index) => {
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
          alert("File " + file.name + " terlalu besar (max 2 MB)");
          return;
        }

        let fileId = `file-${this.uploadedFiles.length + 2}`;
        this.uploadedFiles.push({ id: fileId, file });

        let fileURL = URL.createObjectURL(file);

        let filePreview = `
          <div class="col-md-3 position-relative text-start p-2 d-inline-flex align-items-center me-3" id="${fileId}">
            <a href="${fileURL}" target="_blank" class="text-decoration-none">${file.name}</a>
            <button class="btn btn-sm text-danger ms-2 remove-file" data-id="${fileId}" style="border: none; background: transparent;">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        `;

        tampilAttach.append(filePreview);
      });

      // Reset input file agar bisa pilih file sama lagi
      $("#attach").val("");
    });

    // Event hapus file
    $(document).on("click", ".remove-file", (event) => {
      event.preventDefault();
      $("#uploadfile").fadeIn();

      let fileId = $(event.currentTarget).data("id");
      $("#" + fileId).remove();
      this.uploadedFiles = this.uploadedFiles.filter(f => f.id !== fileId);
    });
  }


   setdoducument(){
     let document_old = $("#document_old").val();
     
    
      if(document_old.trim() !== ""){
         const document = document_old.split(",")
         const tampilAttach = $("#tampil_attach");
         $.each(document,function(a,b){
             let filePreview = `
              <div class="col-md-3 position-relative text-start p-2 d-inline-flex align-items-center me-3" id="${a}">
                <a href="${url_store+b}" target="_blank" class="text-decoration-none">${b}</a>`;
            filePreview +=(pageMode ==="edit") ?`
            <button class="btn btn-sm text-danger ms-2 remove-file" data-id="${a}" style="border: none; background: transparent;">
            <i class="fa-solid fa-xmark"></i>
            </button>` : ``;
           filePreview +=`</div>
            `;
         tampilAttach.append(filePreview);
         })
      }
   }
}

export default AttachAdd;
