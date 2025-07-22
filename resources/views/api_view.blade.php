<select name="province" id="province" class="form-select">
    <option value="">Pilih Provinsi</option>
    @foreach ($data['data'] as $province)
        <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
    @endforeach
</select>