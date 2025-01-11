{{ $idType }} - {{ $id_number }}

<br>
<br>
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset("id-photo/$front_id"))) }}"
    style="width: 50%; height: auto;">
<br>
<br>
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset("id-photo/$back_id"))) }}"
    style="width: 50%; height: auto;">
