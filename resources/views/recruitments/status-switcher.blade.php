<div class="light-modal" id="recruitment-modal" role="dialog" aria-labelledby="light-modal-label" aria-hidden="false">
    <div class="light-modal-content large-content animated fadeIn">
        <div class="light-modal-header">
            <h3 class="light-modal-heading">@yield('modalHeader')</h3>
            <a href="#" class="light-modal-close-icon" aria-label="close">&times;</a>
        </div>
        <div class="light-modal-body">@yield('modalContent')</div>
        <div class="light-modal-footer">
            <div class="buttons">@yield('modalFooter')</div>
        </div>
    </div>
</div>