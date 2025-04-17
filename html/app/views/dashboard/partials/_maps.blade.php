<div class="panel panel-default">
    <input type="hidden" value="{[ $permMapEdit ]}" id="permMapEdit">
    <input type="hidden" value="{[ $permExtraAuth ]}" id="permExtraAuth">
    <div class="panel-body map" id="map">
		<div id="mapnotfound">
		<a href="https://updates.satel.pl/mapeditor/v3.0/map_editor_setup.exe" target="_mapeditordownload">
		<div class="mapdloadbtn"><i class="fa fa-download"></i></div>
	</a></div>
	</div>
@if(Config::get('parameters.soundOnMap', false))
	<audio data-layer="INT-PART" class="state alarm-on fire-on"><source src="/img/snd-part-alarm.mp3"></audio>
	<audio data-layer="INT-ZON" class="state alarm-on"><source src="/img/snd-part-alarm.mp3"></audio>
@endif
</div>
<script type="text/javascript">
    document.showTime={[Config::get('parameters.timeOnDashboard', 0)]};
</script>
