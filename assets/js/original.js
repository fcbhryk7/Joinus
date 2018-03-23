    // このJSはオリジナルで作成しています。

    // calender表示(時刻あり)
    $(function(){
        $('.datetimepicker').datetimepicker();
    });

    // calender表示(時刻なし)
    var picker = new Pikaday(
    {
        field: document.getElementById('datepicker'),
        firstDay: 1,
        minDate: new Date(1900, 01, 01),
        maxDate: new Date(2020, 12, 31),
        yearRange: [1900,2020]
    });

    // slick Java Script
    $(document).ready(function(){
      $('.your-class').slick({
        // setting-name: setting-value,
        dots: true,
        arrows: false,
      });
    });

    // cropper JS
    $(function(){
        // profile用
        if ($('input#profile-image').length) {
            // 初期設定
            var options =
            {
                aspectRatio: 1 / 1,
                viewMode:1,
                crop: function(e) {
                      cropData = $('#select-image').cropper("getData");
                      $("#upload-image-x").val(Math.floor(cropData.x));
                      $("#upload-image-y").val(Math.floor(cropData.y));
                      $("#upload-image-w").val(Math.floor(cropData.width));
                      $("#upload-image-h").val(Math.floor(cropData.height));
                },
                zoomable:false,
                minCropBoxWidth:162,
                minCropBoxHeight:162
            }
            // 初期設定をセットする
            $('#select-image').cropper(options);

            $("#profile-image").change(function(){
                // ファイル選択変更時に、選択した画像をCropperに設定する
                $('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));

                // 無効化ボタンを解除
                $('#image_upload').removeAttr('disabled');
            });
        // plan / request用
        } else if ($('input#plan-image').length) {
            // 初期設定
            var options =
            {
              aspectRatio: 4 / 3,
              viewMode:1,
              crop: function(e) {
                    cropData = $('#select-image').cropper("getData");
                    $("#upload-image-x").val(Math.floor(cropData.x));
                    $("#upload-image-y").val(Math.floor(cropData.y));
                    $("#upload-image-w").val(Math.floor(cropData.width));
                    $("#upload-image-h").val(Math.floor(cropData.height));
              },
              zoomable:false,
              minCropBoxWidth:160,
              minCropBoxHeight:120
            }
            // 初期設定をセットする
            $('#select-image').cropper(options);

            $("#plan-image").change(function(){
                // ファイル選択変更時に、選択した画像をCropperに設定する
                $('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));

                // 無効化ボタンを解除
                $('#image_upload').removeAttr('disabled');
            });
        }

    });

    // コメント追加機能
    $(function(){

        $('#favorite_form').submit(function(event){
            // HTMLでの送信をキャンセル
            event.preventDefault();

            // 操作対象のフォーム要素を取得
            var $form = $(this);

            // 送信
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),

                success: function(result, textStatus, xhr){
                    $('.favorite_button input').remove();
                    $('.favorite_button button').remove();
                    $('.favorite_button').append(result);
                    // console.log(result);
                    // console.log(textStatus);
                    // console.log(xhr);
                },
                error: function(xhr, textStatus, error){
                    // alert('NG...')
                }
            })
        });

        $('#submit').submit(function(event){
            // HTMLでの送信をキャンセル
            event.preventDefault();

            // 操作対象のフォーム要素を取得
            var $form = $(this);

            // 送信
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),

                success: function(result, textStatus, xhr){
                    $('#InsertComment').append(result);
                    // console.log(result);
                    // console.log(textStatus);
                    // console.log(xhr);

                    // コメント数をカウントアップ
                    var comment_count = Number($('#CommentCount').text());
                    comment_count++;
                    $('#CommentCount').text(comment_count);
                },
                error: function(xhr, textStatus, error){
                    // alert('NG...')
                }
            })
        });
    });

    // タグの処理
    $(function(){
        // タグの×印を押した時の処理
        $(document).on('click','.TagClose', function(){
            // console.log($(this).data('tag'));
            // DIVタグの子孫を削除
            $(this).parent('.TagDiv').fadeOut('normal').remove();
        })

        $('#TagButton').click(function(){
            // テキスト情報取得
            var tag_text = $('#TagText').val();
            // タグを追加
            $('#TagHead').append('<div class="btn btn-default btn-xs btn-round TagDiv"><button class="close ml-10 TagClose" data-tag="'+tag_text+'">&times;</button><label class="button-tag">'+tag_text+'</label><input type="hidden" name="tags[]" value="'+tag_text+'"></div>');
            // テキストボックスを空にする
            $('#TagText').val('');

            // inputタグのname属性を修正する
            // $('#TagHead input').each(function(i, elem){
            //     $(elem).attr('name','tag'+i);
            // })
        });
    });
