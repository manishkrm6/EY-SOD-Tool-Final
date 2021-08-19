

iReturnPromise = (x) => {
  
  let resultPromise = new Promise( (resolve,reject) => {
    
    setTimeout( () => {
      x = x + 20;
      if( x > 100)
        resolve(x);
      else  
        reject(new Error("Opps Something went wrong"));
    },3000);

  });


  return resultPromise;

}

async function initFunc (){
  
  let myResult = await iReturnPromise(200);
  console.log(myResult);

}

initFunc();










/* const fs = require('fs');
let str = fs.readFileSync("Test.sql").toString();

let arr = str.split(";");

let i = 0;
for ( let query of arr ){
    console.log(`Query ${i} `,query);
    i++;
} */













/* const queries = ["Select * from", "Update table name ", "delete from", "Insert into", "Alter table table name"];
const n = 2;

const result = new Array(Math.ceil(queries.length / n))
  .fill()
  .map(_ => queries.splice(0, n))

//console.log(result);

for (queryBatch of result){
    console.log(queryBatch.join(';'));
}
 */




