<li id="{fbid}" class="frmb-choice-group">

  <label for="{fbid}.selected">Mark as correct answer?</label>
  <input type="checkbox" value="1" {?model.selected}checked="checked"{/model.selected} name="{fbid}.selected" id="{fbid}.selected">

  <label for="{fbid}.label">Choice</label>
  <input type="text" value="{model.label}" placeholder="ex: Red" name="{fbid}.label" id="{fbid}.label">

  <label for="{fbid}.Points">Points </label>
  <input type="text" value="{model.Points}" name="{fbid}.Points" id="{fbid}.Points">

  <a href="#" class="frmb-choice-remove">Remove</a>
</li>