<div class="modal__container">
    <input type="checkbox" id="open-modal" class="modal__toggler" />
    <label class="modal__mask" for="open-modal"></label>
    <div class="modal">
        <label class="modal__close" for="open-modal"></label>
        <div class="modal__header">
            <h2 class="modal__title">@yield('title')</h2>
        </div>
        <div class="modal__content">
            @yield('modal')
        </div>
        <div class="modal__footer">
           {{ $modalFooter or '' }}
        </div>
    </div>
</div>