const fs = require('fs');
const { resolve } = require('path');
const path = require('path');

exports.getNumberOfFilesInDir = (dirPath, type) => {

    return new Promise ( (resolve, reject) => {

      fs.readdir(dirPath,  (err, files) => {
        
        if( err ){
          reject(err);
          return
        }

        let total = 0; 
        
          files.forEach(  (file) => {
            fileExt = path.extname(dirPath+'/'+file);
            if( fileExt === type){
              //console.log(total);
              total++;
            }
          });
          
          resolve(total);
          

      });
    });
      
  
  
  
  
  
  
      /* 
      let result  = await fs.readdir(dirPath,  (err, files) => {
                let total = 0; 
                files.forEach(  (file) => {
                  fileExt = path.extname(dirPath+'/'+file);
                  if( fileExt === type){
                    //console.log(total);
                    total++;
                  }
                });
                return total;

               });
               return result; 
      */
}

exports.getNumberOfLines =  (filePath) => {
    return new Promise((resolve, reject) => {
      let lineCount = 0;
      fs.createReadStream(filePath)
        .on("data", (buffer) => {
          let idx = -1;
          lineCount--; // Because the loop will run once for idx=-1
          do {
            idx = buffer.indexOf(10, idx+1);
            lineCount++;
          } while (idx !== -1);
        }).on("end", () => {
          resolve(lineCount);
        }).on("error", reject);
      });
  };