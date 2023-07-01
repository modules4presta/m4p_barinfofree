<div class="m4p_barinfofree" id="close-display-top-bar-m4p-content" style="background-color: {$m4p_barinfofree_bar_color};">
    <div class="row">
        <div class="container">
            <div class="col-12">
                <div class="m4p_barinfofree--content">
                    <p style="color:{$m4p_barinfofree_text_color};font-size: {$m4p_barinfofree_text_size}px">{$topbarinformation}</p>
                </div>
            </div>
            {if $m4p_barinfofree_switch}
                <button id="close-display-top-bar-m4p" style="color:{$m4p_barinfofree_text_color};font-size: {$m4p_barinfofree_text_size}px">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" fill="{$m4p_barinfofree_text_color}" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1"><path d="M810.65984 170.65984q18.3296 0 30.49472 12.16512t12.16512 30.49472q0 18.00192-12.32896 30.33088l-268.67712 268.32896 268.67712 268.32896q12.32896 12.32896 12.32896 30.33088 0 18.3296-12.16512 30.49472t-30.49472 12.16512q-18.00192 0-30.33088-12.32896l-268.32896-268.67712-268.32896 268.67712q-12.32896 12.32896-30.33088 12.32896-18.3296 0-30.49472-12.16512t-12.16512-30.49472q0-18.00192 12.32896-30.33088l268.67712-268.32896-268.67712-268.32896q-12.32896-12.32896-12.32896-30.33088 0-18.3296 12.16512-30.49472t30.49472-12.16512q18.00192 0 30.33088 12.32896l268.32896 268.67712 268.32896-268.67712q12.32896-12.32896 30.33088-12.32896z"/></svg>
                </button>
            {/if}
        </div>
    </div>
</div>
