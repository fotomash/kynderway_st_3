<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label>
            <input type="hidden" name="reference_id" id="reference_id" value="{{ $reference_id }}">
            <input disabled='disabled' type="file" class="upload-attachment" name="file" accept="image/*, .txt, .rar, .zip" style="display: none;"/>
        </label>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" style="padding-left: 15px;" placeholder="Type a message.."></textarea>
        <button disabled='disabled'><span class="fas fa-paper-plane"></span></button>
    </form>
</div>