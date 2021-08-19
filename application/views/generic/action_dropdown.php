 <div class="row">
    <form class="form-inline">
        <div class="form-group mx-sm-3">
            <label for="inputPassword2" class="sr-only">Action</label>
            <select class="form-control" name="action" id="action" class="action" >
                <option value="none">--Select any Action--</option>
                <?php 
                    if( !empty($options) ) { 
                        foreach ($options as $key => $value) {
                ?>
                <option value="<?= $key; ?>"><?= $value; ?></option>
                <?php } } ?>

            </select>
        </div>
        <button type="button" id="btnAction" class="btn btn-outline-success btn-rounded waves-effect waves-light">Submit</button>
    </form>
 </div>