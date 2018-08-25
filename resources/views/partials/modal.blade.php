<section class="modal--show" id="modal-text" tabindex="-1" role="dialog" 
         aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-inner">
        <header id="modal-label"><h2>@yield('modalHeader')</h2></header>
        <div class="modal-content">@yield('modalContent')</div>
        <footer><div class="buttons">@yield('modalFooter')</div></footer>
    </div>
    <a href="#!" class="modal-close" title="Close this" data-close="Close"
        data-dismiss="modal">?</a>
</section>