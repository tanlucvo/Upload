$(document).ready(function(){
    $(".rename").click(function () {
        $("#myModal").modal({
            backdrop: "static",
            keyboard: false,
        });
    });
    $("#newfile").click(function () {
        $("#addFile").modal({
            backdrop: "static",
            keyboard: false,
        });
    });
    $("#newfolder").click(function () {
        $("#addFolder").modal({
            backdrop: "static",
            keyboard: false,
        });
    });

    $(".rename").click(function () {
        var path = $('.custom-menu').data()['link'];
        name = path.substring(path.lastIndexOf("/") + 1, path.length)
        path = path.substring(0, path.lastIndexOf("/"));
        $('#newname').val(name)
        var nameItem = $('.card-title').map(function () {
            return $.trim($(this).text());
        }).get();
        var nameFolder = $('.folder').map(function () {
            return $.trim($(this).text());
        }).get();
        $("#save").click(function () {
            newName = $("#newname").val();
            if (nameItem.includes(newName) || nameFolder.includes(newName)) {
                alert('name esitsx');
                return;
            }

            $.post(
                "http://localhost:8888/BuffaloDrive/Upload/views/rename.php", {
                name: name,
                path: path,
                newname: newName,
            },
                function (data, status) {
                    console.log(status);
                    if (status) {
                        var path = $('.custom-menu').data()['file'];
                        path.find('a').text(newName);
                        location.reload();
                    }
                }
            );
        });
    });

    $(".delete").click(function () {

        var item = $('.custom-menu').data()['file'];
        $("#myModal1").modal({
            backdrop: "static",
            keyboard: false,
        });
        $("#delete").click(function () {
            $.post(
                "http://localhost:8888/BuffaloDrive/Upload/views/delete.php", {
                path: $('.custom-menu').data()['link'],
            },
                function (data, status) {
                    if (status) {
                        item.remove();
                    }
                }
            );
        });
    });
    $('.share').click(function () {
        $.post(
            "http://localhost:8888/BuffaloDrive/Upload/views/sharefile.php", {
            path: $('.custom-menu').data()['link'],
        },
            function (data, status) {
                if (status) {
                    console.log(1);
                }
            }
        );
    })
    $('.folder').click(function(){
        var link = $(this).find('a').attr("href");
        console.log(link)
        location.href = link;
    })
    $('.folder, .file-item').bind("contextmenu", function (event) {
        var path = $(this).find('input').val();
        var name = '';
        if ($(this).hasClass('folder')){
            name = '/'+$(this).find('a:first-child').text();
        }
        name = name.trim();
        $('.custom-menu').data("link",path+''+name);
        $('.custom-menu').data("file", $(this));
        // Avoid the real one
        event.preventDefault();

        // Show contextmenu
        $(".custom-menu").finish().toggle(100).
        
        // In the right position (the mouse)
        css({
            top: event.pageY + "px",
            left: event.pageX + "px"
        });
        
    });
    
    $('.download').click(function () {
        var file = $('.custom-menu').data()['file'];
        name=$('.custom-menu').data()['file'].text().trim();
        if(file.hasClass('folder')){
            $.post(
                "http://localhost:8888/BuffaloDrive/Upload/views/downfolder.php", {
                    path: $('.custom-menu').data()['link'],
                    name: name
                },
                function (data, status) {
                    if (status) {
                        location.reload();
                        window.open("http://localhost:8888/BuffaloDrive/Upload/views/downfolder.php");
                    }
                }
            );
        }
        else{
            var link = $('.custom-menu').data()['link'];
            link = link.replace('C:/xampp/htdocs', 'http://localhost:8888');
            var name = $('.custom-menu').data()['file'].find('a').text();
            $(this).find('a').attr('href', link);
            $(this).find('a').attr('download', name);
        }
        
    })
    // If the document is clicked somewhere
    $('.folder, .file-item').bind("mousedown", function (e) {
        // If the clicked element is not the menu
        if (!$(e.target).parents(".custom-menu").length > 0) {

            // Hide it
            $(".custom-menu").hide(100);
        }
    });


    // If the menu element is clicked
    $(".custom-menu li").click(function () {
        $(".custom-menu").hide(100);
    });
    $(document).click(function(){
        $(".custom-menu").hide(100);
    })
})
