@if (!env('HIDE_FOOTER'))
<footer class="footer "
    style="height:auto;background-color: #000;margin-top:0px!important; text-align: center;">
    @if (env('AGENCY_RAUEN'))
        <a href="https://maisrifas.com/" target="_blank" style="text-decoration: none"><span
                class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por MAIS RIFAS</span></a>
        </div>
    @else
        <a href="https://maisrifas.com/" target="_blank" style="text-decoration: none"><span
                class="text-muted" style="color: #fff!important; font-size: 12px;">Desenvolvido por MAIS RIFAS</span></a>
        </div>
    @endif
</footer>
@endif