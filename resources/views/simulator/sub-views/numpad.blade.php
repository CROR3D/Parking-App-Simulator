<div class="panel panel-primary numpad">

    <div class="num-row">
        <input id="screen" type="text" name="screen" value="" readonly/>
        {!! ($errors->has('screen')) ? $errors->first('screen', ':message') : '' !!}
    </div>

    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">1</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">2</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">3</button>
        </div>
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">4</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">5</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">6</button>
        </div>
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">7</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">8</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">9</button>
        </div>
    </div>
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">C</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default button">0</button>
        </div>
        <div class="btn-group" role="group">
            <button  id="button" class="btn btn-default button" name="enter" type="submit" {{ ($status['entrance'] == 2) ? 'disabled' : ''}}>E</button>
        </div>
    </div>

</div>
