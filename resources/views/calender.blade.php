<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Calender</title>
    </head>
    <body>
        <p>カレンダーUI</p>
        <div id="event-container"></div> <!-- イベントを表示するコンテナ -->

        <table class="tbl">
            <thead class="tbl-head">
                <tr>
                    <th scope="col"></th>
                    @foreach($meetings as $date => $meeting )
                    <th scope="col" class="h_{{$date}}">
                        {{date('n/d',strtotime($date))}}
                        ({{$week[date("w", strtotime($date))]}})
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="tbl-body">
                @for($i=$start_hour; $i<=$end_hour; $i++)
                <tr class="tbl-body_row">
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
    const tableBodyRow = document.querySelector('.tbl-body_row');
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
            block.className = 'event-block';

            const eventStartHour = parseInt(event.start.split(':')[0]);
            const eventStartMinute = parseInt(event.start.split(':')[1]);
            const eventStartTime = eventStartHour + eventStartMinute/60;

            const eventEndHour = parseInt(event.end.split(':')[0]);
            const eventEndMinute = parseInt(event.start.split(':')[1]);
            const eventEndTime = eventEndHour + eventEndMinute/60;

            block.style.left = `${headerStartX}px`; // 適宜調整
            block.style.width = `${headerWidth}px`; // 適宜調整

            // 時間帯に基づいて高さを計算
            const top = (eventStartTime - startHour) * rowHeight + startY; // 開始時間に基づいて位置を調整
            const height = (eventEndTime - eventStartTime) * rowHeight;

            block.style.top = `${top}px`;
            block.style.height = `${height}px`;

            block.innerHTML = `<p>${event.summary}</p>`;

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
            eventContainer.appendChild(eventBlock);
            console.log(eventContainer.appendChild(eventBlock))

            $i++
        });

        $i++
    });
});

</script>

