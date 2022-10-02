// Add Comment Modal
$('#modalButton').click(function (){
    $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});


// Get all reply buttons
let comments = document.getElementById("modalButton").value

// Access the reply button according to the comment_id
for (let i = 1; i <= comments; i++) {
    // Add reply modal
    $('#replyModalButton'+i).click(() => {
        var comment_id = document.getElementById("replyModalButton"+i).value
        document.getElementById("comment_id").setAttribute('value', comment_id)
        $('#replyModal').modal('show')
            .find('#replyModalContent')
            .load($(this).attr('value'));
    });
};
// Get all sub reply buttons
let repliesCount = document.getElementsByClassName("repliesCount")

// Access the sub reply button according to the reply_id
for (var k in repliesCount) {
    let i = repliesCount[k].value
    // Add sub reply modal
    $('#subReplyModalButton'+i).click(() => {
        var reply_id = document.getElementById("subReplyModalButton"+i).value
        document.getElementById("reply_id").setAttribute('value', reply_id)
        $('#subReplyModal').modal('show')
            .find('#subReplyModalContent')
            .load($(this).attr('value'));
    });
    // document.getElementById("subReplyModalButton"+i).onclick = (() => {
    //     var reply_id = document.getElementById("subReplyModalButton"+i).value
    //     document.getElementById("reply_id").setAttribute('value', reply_id)
    //     $('#subReplyModal').modal('show')
    //         .find('#subReplyModalContent')
    //         .load($(this).attr('value'));
    // });
}