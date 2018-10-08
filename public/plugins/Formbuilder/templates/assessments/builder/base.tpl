<form class="frmb-form" role="form">
  <div class="form-group">
    <select class="frmb-add-elem form-control" name="frmb-add-elem" id="frmb-add-elem">
      <option value="">Add new question...</option>
      {#field_types}
      <option value="{key}">{label}</option>
      {/field_types}
    </select>
  </div>
  <ul>
  </ul>
  <button type="submit" class="frmb-save">Save</button>
</form>