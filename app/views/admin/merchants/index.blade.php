<div class="row">
    <div class="col-md-9"><h3 style="margin: 3px 0 0;">{{ $title or '' }}</h3></div>
</div>

<link rel="stylesheet" href="/packages/dhtmlxGrid/sources/dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_web.css">
<script src="/packages/dhtmlxGrid/sources/dhtmlxCommon/codebase/dhtmlxcommon.js"></script>
<script src="/packages/dhtmlxGrid/sources/dhtmlxGrid/codebase/dhtmlxgrid.js"></script>

<table class="table" id="binding-example"></table>

<div id="gridbox" style="height:400px;"></div>

<script>
    var mygrid = new dhtmlXGridObject('gridbox');
    mygrid.setHeader("Sales,Book title,Author,Price");

    mygrid.init();

    mygrid.load("/admin/rest/collections?limit=5&offset=0&model=categories","json");

</script>