<div class="alert-container">
    @if ($errors->any())
        <div class="alert error" role="alert">
            <input type="checkbox" id="alert1"/>
            <label class="close" title="close" for="alert1">
                <i class="fa fa-times"></i>
            </label>
            <p class="inner">
                <strong>Error!</strong> Please check the form below for <strong>errors</strong>
            </p>
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
        @if (is_array($message))
            <div class="alert error">
                <input type="checkbox" id="alert2"/>
                <label class="close" title="close" for="alert2">
                    <i class="fa fa-times"></i>
                </label>
                @foreach ($message as $error)
                    <p class="inner">
                    <strong>Error!</strong> <?php echo $error[0]; ?>
                </p>
                @endforeach
            </div>
        @else
            <div class="alert error">
                <input type="checkbox" id="alert2"/>
                <label class="close" title="close" for="alert2">
                    <i class="fa fa-times"></i>
                </label>
                <p class="inner">
                    <strong>Error!</strong> <?php echo $message; ?>
                </p>
            </div>
        @endif
        <?php Session::forget('error');?>
    @endif
</div>