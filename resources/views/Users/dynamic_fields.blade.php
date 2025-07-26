@if($subcategory->fields->count())
    @foreach($subcategory->fields as $field)
    <div class="col-sm-3 col-12">
        <label class="control-label">{{ $field->label ?? ucfirst($field->field_name) }}<span> *</span></label>
    </div>
        <div class="col-sm-9 col-12">
            <div class="form-group">
            @if($field->field_type === 'text')
                <input type="text" name="custom[{{ $field->field_name }}]" class="form-control">
            @elseif($field->field_type === 'select')
            <div class="custom-select">
                <select name="custom[{{ $field->field_name }}]" class="select2">
                    @foreach($field->field_options ?? [] as $option)
                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        </div>
    
    @endforeach
@else
    <div class="col-12"><p></p></div>
@endif



