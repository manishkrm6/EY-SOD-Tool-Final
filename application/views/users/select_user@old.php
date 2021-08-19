
<div class="container-fluid">
  <div class="row box">
    <div class="col-sm-10 bg-">
      <!--start code here-->
       <h4 class="font-bold font-weight-bold">Select User</h4>
        <div class="col-sm-12 text-center su2">Filter User List</div><br><br>

        <div class="mt-2">
          <div class="hwbox">Company
             <i class="fa fa-0x fa-filter fl py-1 p-2"></i>
              <input type="checkbox" id="c1" name="cb"> <label class="pull-right pt-2" for="c1" ></label>
          </div> 
          <div class="hwboxx">Department
             <i class="fa fa-0x fa-filter fl py-1 p-2"></i>
             <input type="checkbox" id="c2" name="cb"> <label class="pull-right pt-2   "for="c2"></label>
          </div> 
          <div class="hwboxx">Exclude non dialog Users        
             <input type="checkbox" id="c3" name="cb"> 
            <label class="pull-right pr-2 pt-1" for="c3"></label>
          </div> 
          <div class="hwboxx">Include Custum T-code
            <input type="checkbox" id="c4" name="cb">
            <label class="pull-right pr-2 pt-1"for="c4"></label>
          </div>  
       </div><br><br>

         <div class="mt-1">
          <div class="hwbox">Location
             <i class="fa fa-0x fa-filter fl py-1 p-2"></i>
              <input type="checkbox" id="c5" name="cb"> <label class="pull-right pt-2" for="c5"></label>
          </div> 
          <div class="hwboxx">Bussiness process
             <i class="fa fa-0x fa-filter fl py-1 p-2"></i>
             <input type="checkbox" id="c6" name="cb"> <label class="pull-right pt-2"for="c6"></label>
          </div> 
          <div class="hwboxx">Exclude expire users        
             <input type="checkbox" id="c7" name="cb"> 
            <label class="pull-right pr-2 pt-1" for="c7"></label>
          </div> 
          <div class="hwboxx">Exclude expire role for users
            <input type="checkbox" id="c8" name="cb">
            <label class="pull-right pr-2 pt-1"for="c8"></label>
          </div>  
       </div><br><br>
         <div class="mt-1 col-sm-offset-6">
          <div class="hwbox ml-3">Exclude locked Users
              <input type="checkbox" id="c9" name="cb"> <label class="pull-right pt-2 pr-2" for="c9"></label>
          </div> 
          
          <div class="hwboxx">Enforce org element check
            <input type="checkbox" id="c10" name="cb">
            <label class="pull-right pr-2 pt-1"for="c10"></label>
          </div> 
       </div><br>
        <div class="ml-4"><button class="btn btn-danger col-sm- offset-6 my-3" >Filter</button></div>
 
       

       <!--table code start-->

     <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="theadd">
        <tr>
        <th class="">Select All   <input type="checkbox" id="c13" name="cb"> <label class="pull-right"for="c13"></label></th>
        <th>User Name<i class="fa fa-0x fa-filter fl"></i> </th>
        <th>Valid From<i class="fa fa-0x fa-filter fl"></i></th>
        <th>Valid To<i class="fa fa-0x fa-filter fl"></i></th>
        <th>Lock Status<i class="fa fa-0x fa-filter fl"></i></th>
        <th>User Type<i class="fa fa-0x fa-filter fl"></i></th>
        <th>User Group<i class="fa fa-0x fa-filter fl"></i></th>
        <th>Department<i class="fa fa-0x fa-filter fl"></i></th>
        <th>Generic ID<i class="fa fa-0x fa-filter fl"></i></th>
        <th>Enabled<i class="fa fa-0x fa-filter fl"></i></th>
          
        </tr>
      </thead>
      <tbody >
        <tr class="p-0" >
          <td style="padding-top:0px;"><input type="checkbox" id="c14" name="cb"> <label class="pull-left pt-1"for="c14"></label></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td><input type="checkbox" id="c14" name="cb"> <label class="pull-left"for="c14"></label>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table></div>

    <!--table end-->
    <!--total user-->
    <div class="col-sm-2 pl-0"><b>Total Users</b><br><b>Enabled User</b></div>
    <div class="col-sm-2  offset-sm-8"><button class="btn btn-danger offset-5" >Finalize User</button></div>

   

     
    <!--code-->
    </div><!--div col 10 close-->

    <div class="col-sm-2 pr-0">
      <!-- Begin Sidebar -->
 
  <?php $this->load->view('Sidebar');?>
      

    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->