<!DOCTYPE html>
<html lang="en">

<body>
    <iframe scrolling="no" src="{{ config('app.url') . '/generate-interviewsheet-pdf/' . $file->id }}"
        style="width: 100%; height: 600px" frameborder="0"> </iframe>
</body>

</html>
