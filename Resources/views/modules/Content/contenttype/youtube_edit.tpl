{formsetinitialfocus inputId='url'}
<div class="z-formrow">
    {formlabel for='url' __text='URL to the video clip'}
    {formurlinput id='url' group='data'}
    {contentlabelhelp __text='Something like "http://www.youtube.com/watch?v=ABcDEFgHij&feature=dir".'}
</div>

<div class="z-formrow">
    {formlabel for='width' __text="Video display width [in pixels]"}
    {formtextinput id='width' group='data' maxLength='10'}
</div>

<div class="z-formrow">
    {formlabel for='height' __text="Video display height [in pixels]"}
    {formtextinput id='height' group='data' maxLength='10'}
</div>

<div class="z-formrow" style="display: none">
    {formlabel for='text' __text='Video description'}
    {formtextinput id='text' textMode='multiline' cols='40' rows='10' group='data'}
</div>

<div class="z-formrow" style="display: none">
    <div class="z-formnote">
        {formradiobutton id='displayModeInline' dataField='displayMode' value='inline' checked='1' group='data'}
        {formlabel for='displayModeInline' __text='Show video inline'}

        {formradiobutton id='displayModePopup' dataField='displayMode' value='popup' group='data'}
        {formlabel for='displayModePopup' __text='Show video in popup window'}
    </div>
</div>

<div class="z-formrow" style="display: none">
    {formlabel for='height' __text="How to embed the video, when displayed inline"}
    <div class="z-formnote">
        {formradiobutton id='videoModeHTML5' dataField='videoMode' value='HTML5' checked='1' group='data'}
        {formlabel for='videoModeHTML5' __text='HTML5 standard embedding'}

        {formradiobutton id='videoModeFlash' dataField='videoMode' value='flash' group='data'}
        {formlabel for='videoModeFlash' __text='Flash legacy embedding (not recommended)'}
    </div>
</div>

<div class="z-formrow">
    {formlabel for='showRelated' __text='Show related videos'}
    {formcheckbox id='showRelated' group='data'}
</div>

<div class="z-formrow">
    {formlabel for='autoplay' __text='Autoplay the video when displayed'}
    {formcheckbox id='autoplay' group='data'}
</div>
