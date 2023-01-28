<div class="col-md-2 text-start disappear-item">
    <table>
        <tbody>
        <tr>
            <td>
                <h6>Messages: </h6>
            </td>
            <td style="padding-left: 30px;">
                <h6><strong>{{ $topic->messages->count() }}</strong></h6>
            </td>
        </tr>
        <tr>
            <td>
                <h6>Views:</h6>
            </td>
            <td style="padding-left: 30px;">
                <strong>{{ $topic->views }}</strong>
            </td>
        </tr>
        </tbody>
    </table>
</div>
