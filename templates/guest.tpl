<!-- guest.tpl -->
<form method="post" action="guest-edit.php">
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control" value="{$guest['name']}"/>
        </div>
        <div class="form-group">
          <label for="addr1">Address</label>
          <input type="text" name="addr1" id="addr1" class="form-control" value="{$guest['addr1']}"/>
        </div>
        <div class="form-group">
          <input type="text" name="addr2" id="addr2" class="form-control" value="{$guest['addr2']}"/>
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" name="city" id="city" class="form-control" value="{$guest['city']}"/>
        </div>
        <div class="form-group">
          <label for="state">State</label>
          <select id="state" name="state">
            {$guest['states']}
          </select>
        </div>
        <div class="form-group">
          <label for="zip">Zip</label>
          <input type="text" name="zip" id="zip" class="form-control" value="{$guest['zip']}"/>
        </div>
        <div class="form-group">
          <input type="submit" name="save" value="Save" />
        </div>
      </div>
     </div>
    </div>
  </div>
</form>
