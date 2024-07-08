<table id="{{ $id }}"></table>
<script>
    var dataSet = {!!$json!!};
    // var b=JSON.stringify(dataSet);
    // str = b.replace(/\\/g, '');
    // console.log(str);
    $(document).ready(function() {
        $({!!"'#".$id."'"!!}).DataTable({
            data: dataSet,
            columns: [
                @foreach($titles as $title)
                {
                    title: {!!'"'.$title.'"'!!}
                },
                @endforeach
            ]
        });
    });
</script>