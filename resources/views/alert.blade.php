<div class="alert-container">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Error!</strong> Please check the form below for <strong>errors</strong>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert success">
            <input type="checkbox" id="alert2"/>
            <label class="close" title="close" for="alert2">
                <i class="fa fa-times"></i>
            </label>
            <p class="inner">
                <strong>Success!</strong> <?php echo $message; ?>
            </p>
        </div>
        <?php Session::forget('success');?>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Error!</strong> <?php echo $message; ?>
        </div>
        <?php Session::forget('error');?>
    @endif
</div>