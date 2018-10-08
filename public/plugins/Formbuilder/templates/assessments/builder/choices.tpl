<li id="{fbid}" class="frmb-choice-group">

  <label for="{fbid}.selected">Mark as correct answer?</label>
  <input type="checkbox" class="correctchoice" value="1" {?model.selected}checked="checked"{/model.selected} name="{fbid}.selected" id="{fbid}.selected">

  <label for="{fbid}.label">Choice</label>
  <input type="text" value="{model.label}" placeholder="ex: Red" name="{fbid}.label" id="{fbid}.label">

  <label>Points </label>
  <input type="text" name="{fbid}.Points" id="{fbid}.Points" value="{model.Points}">

  <a href="#" class="frmb-choice-remove">Remove</a>
</li>