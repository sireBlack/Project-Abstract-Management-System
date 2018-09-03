$('document').ready(function(){
    $('#addReview').on('click', function(e){
        e.preventDefault();
        let abstractID = $('#abID').val();
        let reviewerID = $('#reID').val();
        let reviewScore = $('#score').val();

        $.ajax({
            url: '../backend/review.php',
            type: 'POST',
            async: false,
            data:{
                'review': 1,
                'abstractID': abstractID,
                'reviewerID': reviewerID,
                'reviewScore': reviewScore
            },
            success: function(data){
                let output = "";
                console.log(data);
            }
        });
    })
});