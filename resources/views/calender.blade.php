<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Calender</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
        <p>This is Calender App</p>
        <div id="event-container"></div> <!-- イベントを表示するコンテナ -->

        <table class="table table-bordered">
            <thead class="table-head">
                <tr>
                    <th scope="col"></th>
                    @foreach($meetings as $date => $meeting )
                    <th scope="col" class="h_{{$date}}">
                        {{date('n月d日',strtotime($date))}}
                        ({{$week[date("w", strtotime($date))]}})
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-body">
                @for($i=$start_hour; $i<=$end_hour; $i++)
                <tr class="table-body_row">
                    <th scope="row">{{$i}}:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            </tbody>
        </table>
    </body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventContainer = document.getElementById('event-container');

    // テーブルの位置とサイズを取得
    const tableBody = document.querySelector('tbody');
    const rect = tableBody.getBoundingClientRect();

    // テーブルの左上の座標
    const startX = rect.left;
    const startY = rect.top;

    // テーブルの行を取得
    const tableBodyRow = document.querySelector('.table-body_row');
    const rowRect = tableBodyRow.getBoundingClientRect();

    // テーブルの行の高さを取得
    const rowHeight = rowRect.height;
    
    // ここで、PHPからJSON形式でデータを渡してもらう
    const meetings = @json($meetings); // 例: PHPでデータをJSON形式に変換して埋め込む
    const week = @json($week);
    const startHour = {{ $start_hour }};
    const endHour = {{ $end_hour }};

    // イベントブロックを生成する関数
    function createEventBlock(event, date, id) {
        // 各カラムの始点の座標を算出
        const headerClassName = 'h_' + date;
        const headerElement = document.querySelector(`.${headerClassName}`);

        // 要素が存在する場合にのみ位置とサイズを取得
        if (headerElement) {
            let rect = headerElement.getBoundingClientRect();
            let headerStartX = rect.left;
            let headerWidth = rect.width;

            const block = document.createElement('div');
            block.className = 'event-block-' + id;

            const eventStartHour = parseInt(event.start.split(':')[0]);
            const eventEndHour = parseInt(event.end.split(':')[0]);

            block.style.position= 'absolute';
            block.style.border = '1px solid #ddd';
            block.style.backgroundColor = '#f9f9f9';
            block.style.padding = '5px';
            block.style.left = `${headerStartX}px`; // 適宜調整
            block.style.width = `${headerWidth}px`; // 適宜調整

            // 時間帯に基づいて高さを計算
            const top = (eventStartHour - startHour) * rowHeight + startY; // 開始時間に基づいて位置を調整
            const height = (eventEndHour - eventStartHour) * rowHeight;

            block.style.top = `${top}px`;
            block.style.height = `${height}px`;

            block.innerHTML = `
                <strong>${event.summary}</strong><br>
                ${event.start} - ${event.end}
            `;

            return block;
        } else {
            console.log('指定したクラス名の要素は存在しません。');
        }
    }

    $i = 0
    // イベントデータをループしてブロックを作成
    Object.keys(meetings).forEach(date => {
        meetings[date].forEach(event => {
            
            const eventBlock = createEventBlock(event, date, $i);
            console.log(event, eventBlock);
            eventContainer.appendChild(eventBlock);

            $i++
        });

        $i++
    });
});

</script>

