/*
 Project                     : Oriole
 Module                      : Utils
 File name                   : validation.min.js
 Description                 : Javascript file used  for form validation and ajax calls
 Copyright                   : Copyright © 2014, Audvisor Inc.
 Written under contract by Robosoft Technologies Pvt. Ltd.
 History                     :
 */
var awsurl = "https://com-audvisor-insight-streams" + environment + "-" + client_id + "/";
var awsvoiceoverurl = "https://com-audvisor-insight-voiceover" + environment + "-" + client_id + "/insight_voiceover/";
function hideAlert()
{
    document.getElementById("alertMsg").style.display = "none";
}
function hideExpertformAlert()
{
    document.getElementById("alertMsg2").style.display = "none";
}
function showAlert()
{
    document.getElementById("alertMsg").style.display = "block";
}
function showAlert2()
{
    document.getElementById("alertMsg2").style.display = "block";
}
function showsuccess()
{
    document.getElementById("successMsg").style.display = "block";
}
function hidesuccess()
{
    document.getElementById("successMsg").style.display = "none";
}
function hideTopicAlert()
{
    document.getElementById("alertMsg1").style.display = "none";
}
function hideexpertform()
{
    document.getElementById("expname").value = "";
    document.getElementById("expmiddlename").value = "";
    document.getElementById("explastname").value = "";
    document.getElementById("exptitle").value = "";
    document.getElementById("expdesc").value = "";
    document.getElementById("promotitle").value = "";
    document.getElementById("images").value = "";
    document.getElementById("bioimage").value = "";
    document.getElementById("thumbnailimage").value = "";
    document.getElementById("promoimage").value = "";
    document.getElementById("listviewimage").value = "";
    document.getElementById("fbshareimage").value = "";
    document.getElementById("expertvoiceover").value = "";
    document.getElementById("exprating").value = "";
    document.getElementById("expprefix").value = "";
}
function setimagepreviewsdivs()
{
    var sAvatarFileName = $("#images").val().trim();
    var bioimage = $("#bioimage").val().trim();
    var thumbimage = $("#thumbnailimage").val().trim();
    var promoimage = $("#promoimage").val().trim();
    var listimage = $("#listviewimage").val().trim();
    var fbshareimage = $("#fbshareimage").val().trim();
    if (sAvatarFileName == "" || sAvatarFileName == null)
    {
        $("#pimages").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (bioimage == "" || bioimage == null)
    {
        $("#pbioimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (thumbimage == "" || thumbimage == null)
    {
        $("#pthumbnailimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (promoimage == "" || promoimage == null)
    {
        $("#ppromoimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (listimage == "" || listimage == null)
    {
        $("#plistviewimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (fbshareimage == "" || fbshareimage == null)
    {
        $("#pfbshareimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
}
function edit_setimagepreviewsdivs()
{
    var sAvatarFileName = $("#images").val().trim();
    var bioimage = $("#bioimage").val().trim();
    var thumbimage = $("#thumbnailimage").val().trim();
    var promoimage = $("#promoimage").val().trim();
    var listimage = $("#listviewimage").val().trim();
    var fbshareimage = $("#fbshareimage").val().trim();
    var src;
    if (sAvatarFileName == "" || sAvatarFileName == null)
    {
        src = $("#previewexpertimage_2x").attr("src");
        $("#pimages").attr("src", src);
    }
    if (bioimage == "" || bioimage == null)
    {
        src = $("#ebioimage").attr("src");
        $("#pbioimage").attr("src", src);
    }
    if (thumbimage == "" || thumbimage == null)
    {
        src = $("#ethumbnailimage").attr("src");
        $("#pthumbnailimage").attr("src", src);
    }
    if (promoimage == "" || promoimage == null)
    {
        src = $("#epromoimage").attr("src");
        $("#ppromoimage").attr("src", src);
    }
    if (listimage == "" || listimage == null)
    {
        src = $("#elistviewimage").attr("src");
        $("#plistviewimage").attr("src", src);
    }
    if (fbshareimage == "" || fbshareimage == null)
    {
        src = $("#efbshareimage").attr("src");
        $("#pfbshareimage").attr("src", src);
    }
}
function isexpertimageselected()
{
    var ret_val = 0;
    var sAvatarFileName = $("#images").val().trim();
    var bioimage = $("#bioimage").val().trim();
    var thumbimage = $("#thumbnailimage").val().trim();
    var promoimage = $("#promoimage").val().trim();
    var listview = $("#listviewimage").val().trim();
    var fbshare = $("#fbshareimage").val().trim();
    if (sAvatarFileName != "" && sAvatarFileName != null)
    {
        ret_val = 1;
    } else if (bioimage != "" && bioimage != null)
    {
        ret_val = 1;
    } else if (thumbimage != "" && thumbimage != null)
    {
        ret_val = 1;
    } else if (promoimage != "" && promoimage != null)
    {
        ret_val = 1;
    } else if (listview != "" && listview != null)
    {
        ret_val = 1;
    } else if (fbshare != "" && fbshare != null)
    {
        ret_val = 1;
    }
    return ret_val;
}
function hideversioneditForm()
{
    $('.audvisor-version-edit-modal').modal('hide');
}
function showAlert1()
{
    document.getElementById("alertMsg1").style.display = "block";
}
function showEditInsight()
{
    $('.audvisor-insight-edit-modal').modal('show');
    document.getElementById("editinsight").style.display = "block";
    document.getElementById("ititle").focus();
    hideAlert();
}
function hideInsightEditForm()
{
    document.getElementById("editinsight").style.display = "none";
    document.getElementById("ititle").value = "";
    $('.audvisor-insight-edit-modal').modal('hide');
}
function onTopicEditBtnClick(id, name, image)
{
    document.getElementById("etopicname").value = name.trim();
    document.getElementById("topicimages").value = "";
    document.getElementById("topicid").value = id;
    document.getElementById("etopicname").focus();
    $("#previewtopicimage_2x").attr("src", image);
    hideTopicAlert();
    showEditTopic();
}
function onVersionEditBtnClick(id, version, url, desc, mandatoryupdate, bundleversion, platform)
{
    desc = decodeURIComponent(desc);
    desc = htmlspecialchars_decode(desc.replace(/\+/g, " "));
    var regex = /<br\s*[\/]?>/gi;
    flddescription = desc.replace(regex, "\n");
    document.getElementById("genericversion").value = version;
    document.getElementById("applicationurl").value = url;
    document.getElementById("versiondescription").value = flddescription;
    document.getElementById("bundledversion").value = bundleversion;
    document.getElementById("versionid").value = id;
    document.getElementById("update").value;
    $('#update').val(mandatoryupdate);
    $('#platform').val(platform);
}
function showimagepreview(input)
{
    if (input.files && input.files[0])
    {
        var filerdr = new FileReader();
        filerdr.onload = function (e)
        {
            $('#previewimage').attr('src', e.target.result);
        }
        filerdr.readAsDataURL(input.files[0]);
    }
}
function showimagespreview(input)
{
    var x = 1, i = 0;
    readExpertURLs(input);
}
function showtopicimagepreview(input)
{
    if (input.files && input.files[0])
    {
        var filerdr = new FileReader();
        filerdr.onload = function (e)
        {
            $('#topicpreviewimage').attr('src', e.target.result);
        }
        filerdr.readAsDataURL(input.files[0]);
    }
}
function showtopicimagespreview(input)
{
    removespans(4);
    var x = 1, i = 0;
    readTopicURLs(input);
}
function readTopicURLs(input)
{
    if (input.files)
    {
        for (var i = 0; i < input.files.length; ++i)
        {
            var file = input.files[i];
            var reader = new FileReader();
            var k = 0;
            reader.onload = function (e)
            {
                var span = document.createElement('span');
                span.setAttribute("id", "span" + k);
                if (++k % 2 == 0)
                {
                    span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(file.name), '" height="90" width="128" id="timgx', k, '" style="border:1px solid #0174DF"/><br><br>'].join('');
                } else
                {
                    span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(file.name), '" height="90" width="128" id="timgx', k, '"  style="border:1px solid #0174DF"/>&nbsp&nbsp&nbsp'].join('');
                }
                document.getElementById('list').insertBefore(span, null);
            };
            reader.readAsDataURL(file);
        }
    }
}
function removespans(length)
{
    for (var i = 0; i < length; i++)
    {
        if (document.getElementById("span" + i))
        {
            $('#span' + i).remove();
        }
    }
}
function setexpertimagespan()
{
    if ($('#eimgx1').length == 0)
    {
        for (var i = 0; i < 1; ++i)
        {
            var span = document.createElement('span');
            span.setAttribute("id", "span" + i);
            var k = i + 1;
            if (k % 2 == 0)
            {
                span.innerHTML = ['<img class="thumb" src="" title="image', k, '" height="90" width="128" id="eimgx', k, '" style="border:1px solid #0174DF"/><br><br>'].join('');
            } else
            {
                span.innerHTML = ['<img class="thumb" src="" title="image', k, '" height="90" width="128" id="eimgx', k, '"  style="border:1px solid #0174DF"/>&nbsp&nbsp&nbsp'].join('');
            }
            document.getElementById('expertlist').insertBefore(span, null);
        }
    }
    var src1 = document.getElementById("previewexpertimage_2x").getAttribute('src');
    $("#eimgx1").attr("src", src1);
}
function settopicimagespan()
{
    if ($('#timgx1').length == 0)
    {
        for (var i = 0; i < 1; i++)
        {
            var span = document.createElement('span');
            span.setAttribute("id", "span" + i);
            var k = i + 1;
            if (k % 2 == 0)
            {
                span.innerHTML = ['<img class="thumb" src="" title="image', k, '" height="90" width="128" id="timgx', k, '" style="border:1px solid #0174DF"/><br><br>'].join('');
            } else
            {
                span.innerHTML = ['<img class="thumb" src="" title="image', k, '" height="90" width="128" id="timgx', k, '"  style="border:1px solid #0174DF"/>&nbsp&nbsp&nbsp'].join('');
            }
            document.getElementById('list').insertBefore(span, null);
        }
    }
    var src1 = document.getElementById("previewtopicimage_2x").getAttribute('src');
    $("#timgx1").attr("src", src1);
}
function readExpertURLs(input)
{
    if (input.files)
    {
        var id = "#p" + input.id;
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e)
        {
            $(id).attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    }
}
function insightpreview(selected)
{
    document.getElementById("previewititle").innerHTML = $("#ititle").val().trim();
    var str = ($('#fbsharedesc').val().trim());
    str = str.replace(/<br\s*[\/]?>/gi, "\n");
    var rating = $("#insightrating").val().trim();
    if (!$("#insightrating").val().trim())
    {
        rating = 50;
    }
    document.getElementById("previewinsightrating").innerHTML = rating;
    var selMulti = $.map($("#topicid option:selected"), function (el, i)
    {
        return $(el).text();
    });
    var playListName = $.map($("#playlistid option:selected"), function (el, i) {
        return $(el).text();
    });
    document.getElementById("previewplaylistid").innerHTML = playListName.join(", ");
    var groupName = $.map($("#groupid option:selected"), function (el, i) {
        return $(el).text();
    });

    document.getElementById("previewtopicid").innerHTML = selMulti.join(", ");
//    document.getElementById("previewgroupid").innerHTML = groupName.join(", ");
    document.getElementById("previewexpid").innerHTML = $("#expid option:selected").text();
    document.getElementById("previewfbsharedesc").value = unescapeHTML(escapeHtml($('#fbsharedesc').val().trim()));
    var filename = $("#insight").val().replace(/C:\\fakepath\\/i, '');
    var vofilename = $("#insightvoiceover").val().replace(/C:\\fakepath\\/i, '');
    if (filename != "" && filename != null)
    {
        document.getElementById("previewfile").innerHTML = filename;
        document.getElementById("previewfilerow").style.display = "block";
    } else
    {
        document.getElementById("previewfilerow").style.display = "none";
    }
    if (vofilename != "" && vofilename != null)
    {
        document.getElementById("previewvofile").innerHTML = vofilename;
        document.getElementById("previewvofilerow").style.display = "block";
    } else
    {
        document.getElementById("previewvofilerow").style.display = "none";
    }
}
function editexpertpreview()
{
    var desc = ($('#expertdesc').val().trim());
    var twitterhandle = $('#twitterhandle').val().trim();
    if (twitterhandle.substr(0, 1) !== "@" && twitterhandle)
    {
        twitterhandle = "@" + twitterhandle;
    }
    if (twitterhandle)
    {
        var twitterhandleurl = "https://twitter.com/" + twitterhandle;
        $("#previewtwitterhandle").attr("href", twitterhandleurl);
    }
    document.getElementById("previewexpertprefix").innerHTML = $('#expertprefix').val().trim();
    document.getElementById("previewexpertname").innerHTML = $('#expertname').val().trim();
    document.getElementById("previewmiddlename").innerHTML = $('#middlename').val().trim();
    document.getElementById("previewlastname").innerHTML = $('#lastname').val().trim();
    document.getElementById("previewexperttitle").innerHTML = escapeHtml($('#experttitle').val().trim());
    document.getElementById("previewexpertdesc").innerHTML = escapeHtml(desc);
    document.getElementById("previewpromotitle").innerHTML = $('#promotitle').val().trim();
    document.getElementById("previewtwitterhandle").innerHTML = escapeHtml(twitterhandle);
    document.getElementById("previewexpertrating").innerHTML = $('#expertrating').val().trim();
    document.getElementById("previewexpertvoiceover").innerHTML = "No File Selected";
    var voiceover = $("#expertvoiceover").val().replace(/C:\\fakepath\\/i, '');
    if (voiceover != null && voiceover != "")
    {
        document.getElementById("previewexpertvoiceover").innerHTML = voiceover;
    }
    var imagename = document.getElementById("images").value;
    edit_setimagepreviewsdivs();
    if (!isexpertimageselected())
    {
        document.getElementById("imgnotavailable").style.visibility = "visible";
        document.getElementById("lblimgselected").style.visibility = "hidden";
        document.getElementById("lblnotselected").style.visibility = "visible";
    } else
    {
        document.getElementById("imgnotavailable").style.visibility = "hidden";
        document.getElementById("lblnotselected").style.visibility = "hidden";
        document.getElementById("lblimgselected").style.visibility = "visible";
    }
}
function expertpreview()
{
    var rating = $('#exprating').val().trim();
    if (!rating)
    {
        rating = 50;
    }
    var twitterhandle = $('#twitterhandle').val().trim();
    if (twitterhandle.substr(0, 1) !== "@" && twitterhandle)
    {
        twitterhandle = "@" + twitterhandle;
    }
    if (twitterhandle)
    {
        var twitterhandleurl = "https://twitter.com/" + twitterhandle;
        $("#previewtwitterhandle").attr("href", twitterhandleurl);
    }
    document.getElementById("previewexpertprefix").innerHTML = $('#expprefix').val().trim();
    document.getElementById("previewexpertname").innerHTML = $('#expname').val().trim();
    document.getElementById("previewmiddlename").innerHTML = $('#expmiddlename').val().trim();
    document.getElementById("previewlastname").innerHTML = $('#explastname').val().trim();
    document.getElementById("previewpromotitle").innerHTML = $('#promotitle').val().trim();
    document.getElementById("previewexperttitle").innerHTML = escapeHtml($('#exptitle').val().trim());
    document.getElementById("previewexpertdesc").innerHTML = escapeHtml($('#expdesc').val().trim());
    document.getElementById("previewexpertrating").innerHTML = rating;
    document.getElementById("previewtwitterhandle").innerHTML = escapeHtml(twitterhandle);
    var voiceover = $("#expertvoiceover").val().replace(/C:\\fakepath\\/i, '');
    if (voiceover != null && voiceover != "")
    {
        document.getElementById("previewexpertvoiceover").innerHTML = voiceover;
    } else
    {
        document.getElementById("previewexpertvoiceover").innerHTML = "No File Selected";
    }
    var imagename = document.getElementById("images").value;
    setimagepreviewsdivs();
    if (!isexpertimageselected())
    {
        document.getElementById("expertimagepresenet").innerHTML = "Images Not Selected";
    } else
    {
        document.getElementById("expertimagepresenet").innerHTML = "";
    }
}
function topicpreview()
{
    document.getElementById("previewtopicname").innerHTML = $('#topicname').val().trim();
    var imagename = document.getElementById("topicimages").value;
    if (imagename == "" || imagename == null)
    {
        document.getElementById("topicimagepresenet").innerHTML = "Image Not Selected";
    } else
    {
        document.getElementById("topicimagepresenet").innerHTML = "";
    }
}
function topiceditpreview()
{
    document.getElementById("previewtopicname").innerHTML = $('#etopicname').val().trim();
    var imagename = document.getElementById("topicimages").value;
    if (imagename == "" || imagename == null)
    {
        if ($('#timgx1').length)
        {
            removespans(4);
        }
        settopicimagespan()
        document.getElementById("imgnotavailable").style.visibility = "visible";
    } else
    {
        document.getElementById("imgnotavailable").style.visibility = "hidden";
    }
}
function enablecontrol(id, targetid)
{
    if (document.getElementById(id).checked)
    {
        document.getElementById(targetid).style.visibility = 'visible';
    } else
    {
        document.getElementById(targetid).style.visibility = 'hidden';
    }
}
function onInsightEditBtnClick(id, name, expertid, topicid, insighturl, streamingurl, rating, voiceover, fbsharedescription, playlistid)
{
    var description = decodeURIComponent(fbsharedescription);
    description = htmlspecialchars_decode(description.replace(/\+/g, " "));
    var regex = /<br\s*[\/]?>/gi;
    var fbdescription = description.replace(regex, "\n");
    if (streamingurl)
    {
        if (streamingurl.search(awsurl) == -1)
        {
            streamingurl = awsurl + streamingurl
        }
        ;
        document.getElementById("insightmp3").src = streamingurl;
        document.getElementById("editinsightplayer").load();
        document.getElementById("lblnostreamurl").style.display = "none";
        document.getElementById("editinsightplayer").style.display = "block";
    } else
    {
        document.getElementById("lblnostreamurl").style.display = "block";
        document.getElementById("editinsightplayer").style.display = "none";
        document.getElementById("insightmp3").src = "";
    }
    if (voiceover)
    {
        voiceover = awsvoiceoverurl + voiceover;
        document.getElementById("voiceovermp3").src = voiceover;
        document.getElementById("editinsightvoplayer").load();
        document.getElementById("lblnovourl").style.display = "none";
        document.getElementById("editinsightvoplayer").style.display = "block";
    } else
    {
        document.getElementById("lblnovourl").style.display = "block";
        document.getElementById("editinsightvoplayer").style.display = "none";
        document.getElementById("voiceovermp3").src = "";
    }
    document.getElementById("fbsharedesc").value = fbdescription;
    document.getElementById("ititle").value = name;
    document.getElementById("insightid").value = id;
    document.getElementById("insighturl").value = insighturl;
    document.getElementById("streamingurl").value = streamingurl;
    document.getElementById("insightrating").value = rating;
    document.getElementById("insight").value = "";
    $("#topicid").multiselect('rebuild');
    $("#expid").multiselect('rebuild');
    var res = topicid.replace("[", "");
    res = res.replace("]", "");
    var topicids = res.split(",");
    $("#expid option:selected").removeAttr("selected");
    $("#expid").multiselect('select', expertid.trim());
    $("#expid").multiselect('refresh');
    $("#topicid option:selected").removeAttr("selected");
    $("#topicid").multiselect('refresh');
    for (var i = 0; i < topicids.length; i++)
    {
        $("#topicid").multiselect('select', topicids[i]);
    }
    if (playlistid != null) {
        var res1 = playlistid.replace("[", "");
        res1 = res1.replace("]", "");
        var playlistids = res1.split(",");
        $("#playlistid option:selected").removeAttr("selected");
        $("#playlistid").multiselect('refresh');
        for (var i = 0; i < playlistids.length; i++)
        {

            $("#playlistid").multiselect('select', playlistids[i]);

        }
    }
    var ext = insighturl.split('.').pop();
    var iname = insighturl;
    var audiolink = iname.replace('insights1/', '');
    insighturl = audiolink.replace(ext, '');
    insighturl = insighturl.replace('.', '');
    hidesuccess();
    showEditInsight();
}
function nocopyspecialchars(valfldid)
{
    var obj = document.getElementById(valfldid);
    var cur_text = obj.value;
    new_text = cur_text.replace(/[^0-9a-zA-Z!@#$%^&*'.():-]/g, "");
    if (cur_text != new_text)
    {
        obj.value = new_text;
    }
}
function no_nonnumbers(fld)
{
    var obj = document.getElementById(fld);
    var cur_text = obj.value;
    new_text = cur_text.replace(/[^0-9]/g, "");
    if (cur_text != new_text)
    {
        obj.value = new_text;
        alert("Only Numeric Values Allowed");
    }
}
function rating_range(fld)
{
    var obj = document.getElementById(fld);
    var cur_text = obj.value;
    var new_text = cur_text.replace(/[^0-9]/g, "");
    if (cur_text == "")
    {
        new_text = "";
    } else if (cur_text > 100)
    {
        new_text = 10;
    } else if (cur_text < 1)
    {
        new_text = 10;
    }
    if (cur_text != new_text)
    {
        obj.value = "";
        alert("Only Numeric Values Allowed. Accepted Range 1 - 100");
    }
}
function reputation_range(fld)
{
    var obj = document.getElementById(fld);
    var cur_text = obj.value;
    var new_text = cur_text.replace(/[^0-9]/g, "");
    if (cur_text == "")
    {
        new_text = "";
    } else if (cur_text > 10)
    {
        new_text = 10;
    } else if (cur_text < 1)
    {
        new_text = 10;
    }
    if (cur_text != new_text)
    {
        obj.value = "";
        alert("Only Numeric Values Allowed Accepted Range 1 - 10");
    }
}
function validformdata(selected)
{
    var ititle = $("#ititle").val().trim();
    var expertid = $("#expid").val();
    var ifile = $("#insight").val().trim();
    var voiceoverfile = $("#insightvoiceover").val().trim();
    ;
    var rv = 0;
    if (ititle == "" || ititle == null)
    {
        document.getElementById("alertMsg").innerHTML = "Enter the Insight Title";
        showAlert();
        $("#ititle").focus();
        rv = 1;
    } else if (selected == "" || selected == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Topic";
        document.getElementById("topicid").focus();
        rv = 1;
    } else if (expertid == "" || expertid == -1 || expertid == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Expert";
        document.getElementById("expid").focus();
        rv = 1;
    } else if (ifile == "" || ifile == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Insight File ";
        document.getElementById("insight").focus();
        rv = 1;
    } else if (voiceoverfile == "" || voiceoverfile == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Voice-Over File ";
        document.getElementById("insightvoiceover").focus();
        rv = 1;
    }
    return rv;
}
function validexpformdata()
{
    var expname = document.getElementById("expname").value.trim();
    var expmiddlename = document.getElementById("expmiddlename").value.trim();
    var explastname = document.getElementById("explastname").value.trim();
    var exptitle = document.getElementById("exptitle").value.trim();
    var expdesc = document.getElementById("expdesc").value.trim();
    var voicefile = $("#expertvoiceover").val().trim();
    var rv = 0;
    if (expname == "" || expname == null)
    {
        showAlert2();
        document.getElementById("alertMsg2").innerHTML = "Enter the First Name";
        document.getElementById("expname").focus();
        document.getElementById('alertMsg2').scrollIntoView();
        rv = 1;
    } else if (explastname == "" || explastname == null)
    {
        showAlert2();
        document.getElementById("alertMsg2").innerHTML = "Enter the Last Name ";
        document.getElementById("explastname").focus();
        document.getElementById('alertMsg2').scrollIntoView();
        rv = 1;
    } else if (exptitle == "" || exptitle == null)
    {
        showAlert2();
        document.getElementById("alertMsg2").innerHTML = "Enter Title ";
        document.getElementById("exptitle").focus();
        document.getElementById('alertMsg2').scrollIntoView();
        rv = 1;
    } else if (expdesc == "" || expdesc == null)
    {
        showAlert2();
        document.getElementById("alertMsg2").innerHTML = "Enter Biography";
        document.getElementById("expdesc").focus();
        document.getElementById('alertMsg2').scrollIntoView();
        rv = 1;
    } else if (voicefile == "" || voicefile == null)
    {
        showAlert2();
        document.getElementById("alertMsg2").innerHTML = "Please Select Voice-Over Audio  ";
        document.getElementById("expertvoiceover").focus();
        document.getElementById('alertMsg2').scrollIntoView();
        rv = 1;
    }
    return rv;
}
function uploadLogo(sinformId, expertId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({url: apibaseurlString + 'experts/' + expertId + '/uploadexpertimage', type: 'POST', data: formData, async: false, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Image upload failed');
            } else
            {
                logoPath = data.thumbnail;
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
}
function updateAvatar(sinformId, expertId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({url: apibaseurlString + 'experts/' + expertId + '/updateexpertimage', type: 'POST', data: formData, async: false, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Image upload failed');
            } else
            {
                logoPath = data.thumbnail;
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
}
function uploadexprtsvoiceoverAudio(sinformId, expertId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({url: apibaseurlString + 'experts/' + expertId + '/uploadexpertvoiceover', type: 'POST', data: formData, async: false, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Voice over upload failed');
            } else
            {
                logoPath = data.thumbnail;
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
}
function uploadTopicLogo(sinformId, topicId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({url: apibaseurlString + 'topics/' + topicId + '/uploadtopicimage', type: 'POST', data: formData, async: false, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Image upload failed');
            } else
            {
                logoPath = data.thumbnail;
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
}
function uploadAudio(sInsightID, sinformId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({type: 'POST', async: false, url: apibaseurlString + 'insights/' + sInsightID + '/' + 'uploadaudio', data: formData, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Insight upload failed');
            } else if (data.code == 323)
            {
                var confirmVal = confirm("Insight Duration is less than 10 sec do you want to Delete it? \n \nPress OK to continue, or click Cancel to abort the deletion.");
                if (confirmVal == true)
                {
                    var datatosend = null;
                    var type = "delete";
                    var sync = false;
                    var url = apibaseurlString + 'insights/' + sInsightID;
                    var typeofdata = 'json';
                    var data = ajaxcall(type, sync, url, datatosend, typeofdata);
                    location.reload();
                }
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
    return logoPath;
}
function uploadInsightvoiceover(sInsightID, sinformId)
{
    var mForm = document.getElementById(sinformId);
    var formData = new FormData(mForm);
    var logoPath = "";
    $.ajax({type: 'POST', async: false, url: apibaseurlString + 'insights/' + sInsightID + '/' + 'uploadvoiceoveraudio', data: formData, success: function (data)
        {
            if (data.code == 255)
            {
                alert('Insight Voice-Over upload failed');
            } else
            {
                logoPath = data.thumbnail;
            }
        }, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }, cache: false, contentType: false, processData: false});
    return logoPath;
}
function submitform(selected, selected_playlist)
{
    var rating = $('#insightrating').val().trim();
    if (!rating)
    {
        rating = 50;
    }
    function formToJSON()
    {
        return JSON.stringify({"title": $('#ititle').val().trim(), "topic_ids": selected, "expert_id": $('#expid').val().trim(), "group_id": $('#groupid').val().trim(), "rating": rating, "fbshare_description": $('#fbsharedesc').val().trim(), "playlist_id": selected_playlist});
    }
    $.ajax({type: "POST", async: false, url: apibaseurlString + 'addinsights', data: formToJSON(), success: function (responseJSON)
        {
            var fId = "regform";
            uploadAudio(responseJSON.id, fId);
            uploadInsightvoiceover(responseJSON.id, fId);
            $('#ititle').val("");
            $("#insight").val("");
            $("#fbsharedesc").val("");
            $("#insightvoiceover").val("");
            $("#insightreputation").val("");
            $("#topicid option:selected").removeAttr("selected");
            $('#expid').prop('selectedIndex', 0);
        }, statusCode: {200: function ()
            {
                hideinsightpreview();
                clearinsightform();
                showinsightsuccess();
                hideAlert();
                $('#btnsubmitinsight').disabled = false;
            }, 404: function ()
            {}}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
}
function hideexpertmodalform()
{
    document.getElementById("regform1").style.display = "none";
    document.getElementById("expertaddbutton").style.display = "none";
}
function showexpertpreviewmodal()
{
    document.getElementById("previewexpertForm").style.display = "block";
    document.getElementById("expertpreviewbutton").style.display = "block";
}
function showexpertmodalform()
{
    document.getElementById("previewexpertForm").style.display = "none";
    document.getElementById("expertpreviewbutton").style.display = "none";
    document.getElementById("regform1").style.display = "block";
    document.getElementById("expertaddbutton").style.display = "block";
}
function showtopicmodalform()
{
    document.getElementById("topicpreviewbutton").style.display = "none";
    document.getElementById("previewtopicform").style.display = "none";
    document.getElementById("newtopicAddForm").style.display = "block";
    document.getElementById("topicaddbutton").style.display = "block";
}
function showeditexpertmodalform()
{
    hideAlert();
    document.getElementById("previewexpertForm").style.display = "none";
    document.getElementById("expertpreviewbutton").style.display = "none";
    document.getElementById("editexpertForm").style.display = "block";
    document.getElementById("expertaddbutton").style.display = "block";
}
function editexpertconirmation()
{
    if (!isUpdateExpertValid())
    {
        editexpertpreview();
        showexpertpreviewForm();
    }
}
function expertconirmation(isexpert)
{
    var sAvatarFileName = $("#images").val().trim();
    if (sAvatarFileName == "" || sAvatarFileName == null)
    {
        removespans(4);
    }
    hidesuccess();
    if (!validexpformdata())
    {
        $('#btneditexpert').removeAttr("disabled");
        hideExpertformAlert();
        expertpreview();
        showexpertpreviewForm();
        if (isexpert)
        {
            hideexpertmodalform();
            showexpertpreviewmodal();
        }
    }
}
function showtopicpreviewform()
{
    $('.audvisor-topic-preview-modal').modal('show');
}
function hidetopicpreviewform()
{
    $('.audvisor-topic-preview-modal').modal('hide');
}
function topiceditconirmation()
{
    if (!isUpdateTopicValid())
    {
        topiceditpreview();
        showtopicpreviewform();
    }
}
function topicconirmation(istopic)
{
    if (!isAddTopicValid())
    {
        var sAvatarFileName = $("#topicimages").val().trim();
        if (sAvatarFileName == "" || sAvatarFileName == null)
        {
            removespans(4);
        }
        hideTopicAlert();
        $('#btnAddtopic').removeAttr("disabled");
        topicpreview();
        showtopicpreviewform();
        if (istopic)
        {
            hidetopicmodalform();
            showtopicpreviewmodal();
        }
    }
}
function editinsightconfirmation(selected, selected_playlist)
{
    if (!isUpdateInsightValid(selected))
    {
        insightpreview(selected);
        showinsightpreview();
    }
}
function insightconfirmation(selected)
{
    if (!validformdata(selected))
    {
        insightpreview(selected);
        showinsightpreview();
        $("#btnsubmitinsight").removeAttr("disabled");
    }
}
function showinsightpreview()
{
    $('.audvisor-insight-preview-modal').modal('show');
}
function hideinsightpreview()
{
    $('.audvisor-insight-preview-modal').modal('hide');
}
function showtopicpreviewmodal()
{
    document.getElementById("topicpreviewbutton").style.display = "block";
    document.getElementById("previewtopicform").style.display = "block";
}
function hidetopicpreviewmodal()
{
    document.getElementById("topicpreviewbutton").style.display = "none";
    document.getElementById("previewtopicform").style.display = "none";
}
function hidetopicmodalform()
{
    document.getElementById("newtopicAddForm").style.display = "none";
    document.getElementById("topicaddbutton").style.display = "none";
}
function submitexpform(formid)
{
    var fId = "regform1";
    document.getElementById("btneditexpert").disabled = true;
    var rating = $('#exprating').val().trim();
    if (!rating)
    {
        rating = 50;
    }
    var expertbio = $('#expdesc').val().trim();
    var experttitle = $('#exptitle').val().trim();
    var promotitle = $('#promotitle').val().trim();
    var prefix = $('#expprefix').val().trim();
    var twitterhandle = $('#twitterhandle').val().trim();
    if (!validexpformdata())
    {
        function formToJSON()
        {
            var avatarPath = $('#images').val();
            return JSON.stringify({"name": $('#expname').val().trim(), "title": experttitle, "middlename": $('#expmiddlename').val().trim(), "lastname": $('#explastname').val().trim(), "rating": rating, "description": expertbio, "promotitle": promotitle, "prefix": prefix, "twitter_handle": twitterhandle});
        }
        $.ajax({type: "POST", async: false, url: apibaseurlString + 'addexperts', data: formToJSON(), dataType: 'json', success: function (data)
            {
                if (data["status"] == 1)
                {
                    alert('Expert already exists');
                    if (formid)
                    {
                        showexpertmodalform();
                    } else
                    {
                        hideexpertpreviewForm();
                    }
                    return;
                } else if (data["status"] == 4)
                {
                    expertreenable(data['id']);
                    return;
                }
                var fId = "regform1";
                uploadexprtsvoiceoverAudio(fId, data["records"]["expert_id"]);
                if (isexpertimageselected())
                {
                    uploadLogo(fId, data["records"]["expert_id"]);
                }
                try
                {
                    document.getElementById("successMsg").innerHTML = "Expert added successfully";
                    document.getElementById("images").value = "";
                    document.getElementById("expertvoiceover").value = "";
                    document.getElementById("twitterhandle").value = "";
                    document.getElementById("promotitle").value = "";
                    showsuccess();
                    hideexpertpreviewForm();
                    hideExpertformAlert();
                    if (formid)
                    {
                        var selection = document.getElementById("expid");
                        var option = document.createElement("option");
                        option.value = data["records"]["expert_id"];
                        option.text = data["records"]["expert_name"];
                        selection.appendChild(option);
                        $('#expid').multiselect('rebuild');
                        $('#expid').multiselect('select', data["records"]["expert_id"]);
                        $('#expid').multiselect('refresh');
                        hideExpertaddForm();
                    } else
                    {
                        hideexpertform();
                    }
                    hideexpertform();
                } catch (error)
                {
                    alert("Error:" + error);
                }
            }, statusCode: {}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function onVersionDeleteBtnClick(versionid)
{
    var confirmVal = confirm("Are you sure you want to delete this Version ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        $.ajax({type: "delete", url: apibaseurlString + 'versions/' + versionid, success: function (data)
            {
                if (data == 2)
                {
                    alert('Error occured while deleting');
                    return 0;
                }
                location.reload();
            }, statusCode: {404: function ()
                {
                    alert('Page not found');
                }}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function updateversion()
{
    var genericversion = document.getElementById("genericversion").value.trim();
    var apprul = document.getElementById("applicationurl").value.trim();
    var description = document.getElementById("versiondescription").value.trim();
    var bundleversion = document.getElementById("bundledversion").value.trim();
    var update = document.getElementById("update").value.trim();
    var platform = document.getElementById("platform").value.trim();
    var id = document.getElementById("versionid").value.trim();
    if (!validversionformdata())
    {
        function formToJSON()
        {
            return JSON.stringify({"app_version": genericversion, "app_store_url": apprul, "version_description": description, "bundle_version": bundleversion, "platform": platform, "mandatory_update": update});
        }
        $.ajax({type: "PUT", async: false, url: apibaseurlString + 'versions/' + id, data: formToJSON(), dataType: 'json', success: function (data)
            {
                location.reload();
            }, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function submitversion()
{
    var genericversion = document.getElementById("genericversion").value.trim();
    var apprul = document.getElementById("applicationurl").value.trim();
    var description = document.getElementById("versiondescription").value.trim();
    var bundleversion = document.getElementById("bundledversion").value.trim();
    var update = document.getElementById("update").value.trim();
    var platform = document.getElementById("platform").value.trim();
    document.getElementById("btnaddversion").disabled = true;
    if (!validversionformdata())
    {
        function formToJSON()
        {
            return JSON.stringify({"app_version": genericversion, "app_store_url": apprul, "version_description": description, "bundle_version": bundleversion, "platform": platform, "mandatory_update": update});
        }
        $.ajax({type: "POST", async: false, url: apibaseurlString + 'versions', data: formToJSON(), dataType: 'json', success: function (data)
            {
                showsuccess();
                hideAlert();
                hideversiontpreviewForm();
                hideversionform();
            }, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function hidenewTopicForm()
{
    document.getElementById("newtopicAdd").style.display = "none";
    document.getElementById("topicname").value = "";
}
function showAddTopic()
{
    document.getElementById("newtopicAdd").style.display = "block";
    document.getElementById("topicname").focus();
    hideAlert();
}
function UpdateTopic()
{
    var topicName = document.forms["newtopicEditForm"]["etopicname"].value.trim();
    var topicid = document.forms["newtopicEditForm"]["topicid"].value.trim();
    if (!isUpdateTopicValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"topic_id": topicid, "topic_name": topicName});
        }
        $.ajax({type: "put", url: apibaseurlString + 'topics/' + topicid, data: formToJSON(), dataType: 'json', success: function (response)
            {
                if (response.status == 0)
                {
                    var fId = "newtopicEditForm";
                    var sAvatarFileName = $("#topicimages").val().trim();
                    if (sAvatarFileName != "" && sAvatarFileName != null)
                    {
                        uploadTopicLogo(fId, response['topic']['id']);
                    }
                    document.getElementById(response['topic']['id']).innerHTML = response['topic']['title'];
                    hideupdateForm();
                    hidetopicpreviewform();
                    location.reload();
                } else if (response.status == 2)
                {
                    hidetopicpreviewform();
                    alert("Topic \"" + response.topic_name + "\" exists." + " If you have previously deleted \"" + response.topic_name + "\" kindly add it again");
                } else if (response.status == 3)
                {
                    location.reload();
                }
            }, statusCode: {200: function ()
                {
                    hideupdateForm();
                    hidetopicpreviewform();
                    location.reload();
                }}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function isUpdateInsightValid(selected)
{
    var rv = 0;
    var ititle = document.getElementById("ititle").value;
    var insight = document.getElementById("insight").value.trim();
    var rating = $("#insightrating").val().trim();
    if (ititle == "" || ititle == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter the Title";
        document.getElementById("ititle").focus();
        rv = 1;
    } else if (rating == "" || rating == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter the Rating(1-100)";
        document.getElementById("insightrating").focus();
        rv = 1;
    } else if (selected == 0)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter the topic";
        document.getElementById("topicid").focus();
        rv = 1;
    }
    return rv;
}
function updateInsight(selected, topics, selected_playlist, playlists)
{
    var insightName = document.getElementById("ititle").value.trim();
    var url = document.getElementById("insighturl").value.trim();
    var updateurl = document.getElementById("insight").value.trim();
    var insightid = $('#insightid').val().trim();
    var streamurl = document.getElementById("streamingurl").value.trim();
    var rating = $('#insightrating').val().trim();
    var fld = "regform";
    if (!isUpdateInsightValid(selected))
    {
        function formToJSON()
        {
            return JSON.stringify({"type": "insight", "title": $('#ititle').val().trim(), "id": $('#insightid').val().trim(), "topic_ids": selected, "expert_id": $('#expid').val().trim(), "rating": rating, "fbshare_description": $('#fbsharedesc').val().trim(), "playlist_id": selected_playlist});
        }
        $.ajax({type: "put", async: false, url: apibaseurlString + 'insights/' + insightid, data: formToJSON(), success: function ()
            {
                var voiceover = $("#insightvoiceover").val().trim();
                var sAudioFileName = $("#insight").val().trim();
                if (sAudioFileName != "" && sAudioFileName != null)
                {
                    uploadAudio(insightid, fld);
                }
                if (voiceover != "" && voiceover != null)
                {
                    uploadInsightvoiceover(insightid, fld);
                }
                location.reload();
            }, statusCode: {}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function updateExpert()
{
    var expertName = document.forms["editexpertForm"]["expertname"].value.trim();
    var middlename = document.forms["editexpertForm"]["middlename"].value.trim();
    var lastname = document.forms["editexpertForm"]["lastname"].value.trim();
    var expertid = document.forms["editexpertForm"]["expertid"].value.trim();
    var photourl = document.forms["editexpertForm"]["images"].value.trim();
    var promotitle = $('#promotitle').val().trim();
    var title = document.getElementById("experttitle").value
    var desc = document.getElementById("expertdesc").value.trim();
    var prefix = document.getElementById("expertprefix").value.trim();
    var rating = document.getElementById("expertrating").value.trim();
    var twitterhandle = document.getElementById("twitterhandle").value.trim();
    ;
    var fId = "editexpertForm";
    if (!isUpdateExpertValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"name": expertName, "id": expertid, "middlename": middlename, "lastname": lastname, "title": title, "description": desc, "promotitle": promotitle, "rating": rating, "prefix": prefix, "twitter_handle": twitterhandle});
        }
        $.ajax({type: "put", async: false, url: apibaseurlString + 'experts/' + expertid, data: formToJSON(), success: function (response)
            {
                var voiceover = $("#expertvoiceover").val().trim();
                if (isexpertimageselected())
                {
                    uploadLogo(fId, expertid);
                }
                if (voiceover != "" && voiceover != null)
                {
                    uploadexprtsvoiceoverAudio(fId, expertid);
                }
                if (response.status == 1)
                {
                    showAlert();
                    document.getElementById("alertMsg").innerHTML = "Expert Already Exists";
                    hideexpertpreviewForm();
                } else if (response.status == 4)
                {
                } else
                {
                    hideExpertEditForm();
                    hideexpertpreviewForm();
                    location.reload();
                }
            }, statusCode: {}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function isUpdateExpertValid()
{
    var retVal = 0;
    var expertName = document.forms["editexpertForm"]["expertname"].value.trim();
    var expertmiddlename = document.getElementById("middlename").value.trim();
    var expertlastname = document.getElementById("lastname").value.trim();
    var experttitle = document.getElementById("experttitle").value.trim();
    var expertdesc = document.getElementById("expertdesc").value.trim();
    var expertrating = document.getElementById("expertrating").value.trim();
    if (expertrating == null || expertrating == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Expert Rating";
        document.getElementById("expertrating").focus();
        retVal = 1;
    } else if (expertName == null || expertName == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Expert Name";
        document.getElementById("expertname").focus();
        retVal = 1;
    } else if (expertlastname == null || expertlastname == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Expert Last Name";
        document.getElementById("lastname").focus();
        retVal = 1;
    } else if (experttitle == null || experttitle == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Expert Title";
        document.getElementById("experttitle").focus();
        retVal = 1;
    } else if (expertdesc == null || expertdesc == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Expert Description";
        document.getElementById("expertdesc").focus();
        retVal = 1;
    }
    return retVal;
}
function isUpdateTopicValid()
{
    var retVal = 0;
    var topicName = document.forms["newtopicEditForm"]["etopicname"].value.trim();
    if (topicName == null || topicName == "")
    {
        showAlert1();
        document.getElementById("alertMsg1").innerHTML = "Enter Title";
        document.getElementById("etopicname").focus();
        retVal = 1;
    }
    return retVal;
}
function online(insight_id, expert_img, image_2x, isonline)
{
    var id1 = "isonline2" + insight_id;
    var tempid = "#" + id1;
    var x = 1;
    var row = "isonlinerow" + insight_id;
    if ((image_2x == null || image_2x == "") && (isonline == 0))
    {
        if ((expert_img == null || expert_img == "") && (isonline == 0))
        {
            var confirmVal = confirm("Expert's Profile Image Not Available. Are you sure you want to make this Insight live? \n \nPress OK to continue, or click Cancel to abort the operation.");
            if (confirmVal != true)
            {
                $(tempid).removeAttr("disabled");
                x = 0;
            }
        }
    }
    if (x == 1)
    {
        function formToJSON()
        {
            return JSON.stringify({"insight_id": insight_id});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = false;
        var url = apibaseurlString + 'insights/' + insight_id + '/online';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data["status"] == 1)
        {
            return;
        }
        getInsightstat();
        if (data['result'] == 1)
        {
            $(tempid).removeAttr("disabled");
            document.getElementById(id1).innerHTML = "Online/Offline";
            document.getElementById(row).className = "success";
        } else if (data['result'] == 325)
        {
            alert("No streaming URL available this insight cannot be made online");
        } else
        {
            $(tempid).removeAttr("disabled");
            document.getElementById(id1).innerHTML = "Online/Offline";
            document.getElementById(row).className = "table-striped";
        }
        var table = $('#tableinsight').DataTable();
        table.ajax.reload(null, false);
    } else
    {
    }
}
function hideupdateForm()
{
    document.getElementById("newtopicEdit").style.display = "none";
    document.getElementById("etopicname").value = "";
    $('.audvisor-topic-edit-modal').modal('hide');
}
function hideexpertpreviewForm()
{
    $('.audvisor-expert-preview-modal').modal('hide');
}
function hidetopicpreviewform()
{
    $('.audvisor-topic-preview-modal').modal('hide');
}
function showexpertpreviewForm()
{
    $('.audvisor-expert-preview-modal').modal('show');
}
function hideExpertEditForm()
{
    document.getElementById("editexpert").style.display = "none";
    document.getElementById("expertname").value = "";
    document.getElementById("images").value = "";
    $('.audvisor-expert-edit-modal').modal('hide');
}
function hideExpertaddForm()
{
    document.getElementById("addexpert").style.display = "none";
    document.getElementById("expname").value = "";
    document.getElementById("expmiddlename").value = "";
    document.getElementById("explastname").value = "";
    document.getElementById("exptitle").value = "";
    document.getElementById("images").value = "";
    document.getElementById("bioimage").value = "";
    document.getElementById("thumbnailimage").value = "";
    document.getElementById("promoimage").value = "";
    document.getElementById("listviewimage").value = "";
    document.getElementById("exprating").value = "";
    document.getElementById("expprefix").value = "";
    document.getElementById("twitterhandle").value = "";
    $("#pimages").attr("src", '');
    $("#pbioimage").attr("src", '');
    $("#pthumbimage").attr("src", '');
    $("#ppromoimage").attr("src", '');
    $("#plistviewimage").attr("src", '');
    $("#pfbshareimage").attr("src", '');
    $('.audvisor-expert-add-modal').modal('hide');
}
function showEditTopic()
{
    document.getElementById("newtopicEdit").style.display = "block";
    document.getElementById("etopicname").focus();
    hideTopicAlert();
}
function showaddTopic()
{
    hidesuccess();
    hideTopicAlert();
    showtopicmodalform();
    document.getElementById("newtopicAdd").style.display = "block";
    document.getElementById("topicname").value = "";
    document.getElementById("topicimages").value = "";
    document.getElementById("topicname").focus();
}
function hideaddTopic()
{
    document.getElementById("newtopicAdd").style.display = "none";
    document.getElementById("topicname").value = " ";
    document.getElementById("topicimages").value = "";
    $('.audvisor-topic-add-modal').modal('hide');
}
function showEditExpert()
{
    document.getElementById("editexpert").style.display = "block";
    document.getElementById("expertname").focus();
    hideAlert();
}
function showaddExpert()
{
    hidesuccess();
    hideExpertformAlert();
    showexpertmodalform();
    $("#previewimage").attr("src", "");
    document.getElementById("expname").value = "";
    document.getElementById("expmiddlename").value = "";
    document.getElementById("explastname").value = "";
    document.getElementById("exptitle").value = "";
    document.getElementById("images").value = "";
    document.getElementById("expdesc").value = "";
    document.getElementById("addexpert").style.display = "block";
    document.getElementById("expname").focus();
}
function isAddTopicValid()
{
    var retVal = 0;
    hidesuccess();
    var topicName = $("#topicname").val().trim();
    if (topicName == null || topicName == "")
    {
        showAlert1();
        hidesuccess();
        document.getElementById("alertMsg1").innerHTML = "Enter Title";
        document.getElementById("topicname").focus();
        retVal = 1;
    }
    return retVal;
}
function addTopic(formid)
{
    var topicName = document.getElementById("topicname").value;
    document.getElementById("btnAddtopic").disabled = true;
    if (!isAddTopicValid())
    {
        function formToJSON()
        {
            var avatarPath = $('#topicimages').val();
            var filename = avatarPath.substring(avatarPath.lastIndexOf('\\') + 1);
            return JSON.stringify({"topic_name": topicName});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = false;
        var url = apibaseurlString + 'addtopics';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data["status"] == 1)
        {
            alert('Topic already exists ');
            if (formid)
            {
                showtopicmodalform()
            } else
            {
                hidetopicpreviewform();
            }
            return;
        } else
        {
            var fId = "newtopicAddForm";
            var sAvatarFileName = $("#topicimages").val().trim();
            if (sAvatarFileName != "" && sAvatarFileName != null)
            {
                uploadTopicLogo(fId, data["records"]["topic_id"]);
            }
            document.getElementById("topicimages").value = "";
            document.getElementById("alertMsg1").style.display = "none";
            document.getElementById("successMsg").innerHTML = "Topic added successfully";
            showsuccess();
            document.getElementById("topicimages").value = "";
            if (formid)
            {
                var selection = document.getElementById("topicid");
                var option = document.createElement("option");
                option.value = data["records"]["topic_id"];
                option.text = data["records"]["topic_name"];
                selection.appendChild(option);
                $('#topicid').multiselect('rebuild');
                $('#topicid').multiselect('select', data["records"]["topic_id"]);
                hideaddTopic();
            } else
            {
                document.getElementById("topicname").value = "";
                hidetopicpreviewform();
            }
        }
    }
}
function validateLoginForm()
{
    var UsernameField = document.forms["loginForm"]["userName"].value.trim();
    var PasswordField = document.forms["loginForm"]["password"].value.trim();
    if (UsernameField == null || UsernameField == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter username";
        return false;
    } else if (PasswordField == null || PasswordField == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter password";
        return false;
    }
}
function onTopicDeleteBtnClick(topicid)
{
    var confirmVal = confirm("Are you sure you want to delete this Topic ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        var datatosend = null;
        var type = "delete";
        var sync = false;
        var url = apibaseurlString + 'topics/' + topicid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data == 1)
        {
            alert('This topic is being used by insight(s). Hence it could not be deleted');
            return 0;
        }
        if (data == 2)
        {
            alert('Error occured while deleting');
            return 0;
        }
        location.reload();
    }
}
function onExpertDeleteBtnClick(expertid)
{
    var confirmVal = confirm("Are you sure you want to delete this Expert ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        var datatosend = null;
        var type = "delete";
        var sync = false;
        var url = apibaseurlString + 'experts/' + expertid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data == 1)
        {
            alert('This expert is being used by insight(s).  Hence it could not be deleted');
            return 0;
        }
        if (data == 2)
        {
            alert('Error occured while deleting');
            return 0;
        }
        location.reload();
    }
}
function onInsightDeleteBtnClick(insightid)
{
    var confirmVal = confirm("Are you sure you want to delete this Insight ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        var datatosend = null;
        var type = "delete";
        var sync = false;
        var url = apibaseurlString + 'insights/' + insightid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        var table = $('#tableinsight').DataTable();
        table.ajax.reload(null, false);
    }
}
function escapeHtml(text)
{
    var map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
    return text.replace(/[&<>"']/g, function (m)
    {
        return map[m];
    });
}
function onExpertEditBtnClick(id, firstname, middlename, lastname, image, title, description, image_2x, bioimage, thumbimage, promoimage, promotitle, rating, voiceover, listviewimage, prefix, twitter_handle, fbshareimage)
{
    var tempid = id + "title";
    description = decodeURIComponent(description);
    title = decodeURIComponent(title);
    twitter_handle = decodeURIComponent(twitter_handle);
    twitter_handle = twitter_handle.substring(1)
    twitter_handle = htmlspecialchars_decode(twitter_handle.replace(/\+/g, " "))
    promotitle = decodeURIComponent(promotitle);
    document.getElementById("expertprefix").value = prefix;
    document.getElementById("expertname").value = firstname;
    document.getElementById("middlename").value = middlename;
    document.getElementById("lastname").value = lastname;
    document.getElementById("expertid").value = id;
    document.getElementById("expertrating").value = rating;
    document.getElementById("experttitle").value = htmlspecialchars_decode(title.replace(/\+/g, " "));
    document.getElementById("twitterhandle").value = htmlspecialchars_decode(twitter_handle.replace(/\+/g, " "));
    description = htmlspecialchars_decode(description.replace(/\+/g, " "));
    ;
    var regex = /<br\s*[\/]?>/gi;
    flddescription = description.replace(regex, "\n");
    document.getElementById("expertdesc").value = flddescription;
    document.getElementById("promotitle").value = htmlspecialchars_decode(promotitle.replace(/\+/g, " "));
    ;
    document.getElementById("images").value = "";
    clear_fileinputs();
    if (voiceover)
    {
        document.getElementById("lblexpertvo").style.display = "none";
        document.getElementById("editexpertvoplayer").style.display = "block";
    } else
    {
        document.getElementById("lblexpertvo").style.display = "block";
        document.getElementById("editexpertvoplayer").style.display = "none";
    }
    document.getElementById("expertvoiceovermp3").src = voiceover;
    document.getElementById("editexpertvoplayer").load();
    if (image != "" || image != null)
    {
        $('#previewimage').attr('src', image);
    }
    if (image_2x != "" && image_2x != null)
    {
        $("#previewexpertimage_2x").attr("src", image);
    } else
    {
        $("#previewexpertimage_2x").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (bioimage != "" && bioimage != null)
    {
        $("#ebioimage").attr("src", bioimage);
    } else
    {
        $("#ebioimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (thumbimage != "" && thumbimage != null)
    {
        $("#ethumbnailimage").attr("src", thumbimage);
    } else
    {
        $("#ethumbnailimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (promoimage != "" && promoimage != null)
    {
        $("#epromoimage").attr("src", promoimage);
    } else
    {
        $("#epromoimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (listviewimage != "" && listviewimage != null)
    {
        $("#elistviewimage").attr("src", listviewimage);
    } else
    {
        $("#elistviewimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    if (fbshareimage != "" && fbshareimage != null)
    {
        $("#efbshareimage").attr("src", fbshareimage);
    } else
    {
        $("#efbshareimage").attr("src", cmsbaseurlString + "src/views/images/noimage.png");
    }
    showEditExpert();
}
function disAllowCopyPasteForSpecialCharacters(fldId)
{
    var Obj = document.getElementById(fldId);
    var initVal = Obj.value;
    outputVal = initVal.replace(/[^?=~0-9a-zA-Z!@#$%^&*'.\n,\\ \/ _():-]/g, "");
    if (initVal != outputVal)
    {
        Obj.value = outputVal;
    }
}
function getstatistics()
{
    var datatosend = null;
    var type = "GET";
    var sync = false;
    var url = baseurlString + 'getstatistics';
    var typeofdata = 'json';
    var stat = ajaxcall(type, sync, url, datatosend, typeofdata);
    return stat;
}
function getInsightstat()
{
    var data = getstatistics();
//    var str = data['insightcount'] + "  insights from  " + data['expertcount'] + " experts in " + data['topiccount'] + " topics. | Total listen count: " + data['listen_count'] + ' | Total likes: ' + data['like_count'] + ' | Total shares: ' + data['totalshare_count'] + ' (Fb:' + data['fbshare_count'] + '/SMS:' + data['smsshare_count'] + '/Twitter:' + data['twittershare_count'] + ')';
    var str = data['insightcount'] + "  insights from  " + data['expertcount'] + " experts in " + data['topiccount'] + " topics. ";
    updateStatistics(str);
}
function getTopicstat()
{
    var data = getstatistics();
    var z = 0;
    if (data['insightcount'])
    {
        z = data['insightcount'] / data['topiccount'];
    }
    var str = data['topiccount'] + "  topics with " + data['insightcount'] + "  insights " + "(Average " + z.toFixed(2) + " insights per topic)";
    updateStatistics(str);
}
function getExpertstat()
{
    updateStatistics("str");
    var data = getstatistics();
    var z = 0;
    if (data['insightcount'])
    {
        z = data['insightcount'] / data['expertcount'];
    }
    var str = data['expertcount'] + "  experts with " + data['insightcount'] + "  insights on " + data['topiccount'] + " topics (Average " + z.toFixed(2) + " insights per expert)";
    updateStatistics(str);
}
function updateStatistics(str)
{
    document.getElementById("statistics").innerHTML = str;
}
function validversionformdata()
{
    var genericversion = document.getElementById("genericversion").value.trim();
    var apprul = document.getElementById("applicationurl").value.trim();
    var description = document.getElementById("versiondescription").value.trim();
    var bundledversion = document.getElementById("bundledversion").value.trim();
    var update = document.getElementById("update").value;
    var platform = document.getElementById("platform").value;
    var rv = 0;
    if (genericversion == "" || genericversion == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter the Version";
        document.getElementById("genericversion").focus();
        rv = 1;
    } else if (apprul == "" || apprul == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Application URL ";
        document.getElementById("applicationurl").focus();
        rv = 1;
    } else if (description == "" || description == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Description ";
        document.getElementById("versiondescription").focus();
        rv = 1;
    } else if (bundledversion == "" || bundledversion == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Bundle Version ";
        document.getElementById("bundledversion").focus();
        rv = 1;
    } else if (platform == -1 || platform == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Platform ";
        document.getElementById("platform").focus();
        rv = 1;
    } else if (update == -1 || update == null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Select Mandatory Update ";
        document.getElementById("update").focus();
        rv = 1;
    }
    return rv;
}
function versionconirmation()
{
    hidesuccess();
    if (!validversionformdata())
    {
        $("#btnaddversion").removeAttr("disabled");
        hideAlert();
        versionpreview();
        showversiontpreviewForm();
    }
}
function showversiontpreviewForm()
{
    $('.audvisor-version-preview-modal').modal('show');
}
function hideversiontpreviewForm()
{
    $('.audvisor-version-preview-modal').modal('hide');
}
function versionpreviewclear()
{
    document.getElementById("previewgenericversion").innerHTML = " ";
    document.getElementById("previewapplicationurl").innerHTML = "";
    document.getElementById("previewversiondescription").value = "";
    document.getElementById("previewbundledversion").innerHTML = "";
    document.getElementById("previewupdate").innerHTML = "";
}
function versionpreview()
{
    var str = ($('#versiondescription').val().trim());
    str = str.replace(/<br\s*[\/]?>/gi, "\n");
    versionpreviewclear();
    document.getElementById("previewgenericversion").innerHTML = $('#genericversion').val().trim();
    document.getElementById("previewapplicationurl").innerHTML = $('#applicationurl').val().trim();
    document.getElementById("previewversiondescription").value = escapeHtml(str);
    document.getElementById("previewbundledversion").innerHTML = $('#bundledversion').val().trim();
    document.getElementById("previewupdate").innerHTML = $("#update option:selected").text();
    document.getElementById("previewplatform").innerHTML = $("#platform option:selected").text();
}
function hideversionform()
{
    $("#update").val("-1");
    $("#platform").val("-1");
    document.getElementById("genericversion").value = "";
    document.getElementById("applicationurl").value = "";
    document.getElementById("versiondescription").value = "";
    document.getElementById("bundledversion").value = "";
}
function clearinsightform()
{
    $('#ititle').val("");
    $("#insight").val("");
    $("#insightrating").val("");
    $("#topicid option:selected").removeAttr("selected");
    $("#topicid").multiselect('refresh')
    $('#expid').prop('selectedIndex', 0);
    $("#expid").multiselect('refresh');
}
function showinsightsuccess()
{
    document.getElementById("successMsg").innerHTML = "Insight added successfully";
    showsuccess();
}
function hideinsightsuccess()
{
    document.getElementById("successMsg").innerHTML = "";
    hidesuccess();
}
$(document).ready(function ()
{
    $("*").dblclick(function (e)
    {
        e.preventDefault();
    });
});
function previewExpert(expertid)
{
    $.ajax({type: "get", async: false, url: apibaseurlString + 'experts/' + expertid, success: function (response)
        {
            var id = response.id;
            var name = response, name;
            var firstname = response.firstname;
            var middlename = response.middlename;
            var lastname = response.lastname;
            var bio = response.expert_bio;
            var avatarlink = response.avatar_link;
            var avatarlink_2x = response.avatar_link_2x;
            document.getElementById("previewdeletedexpertname").innerHTML = response['record']['name'];
            document.getElementById("previewdeletedmiddlename").innerHTML = response['record']['middlename'];
            document.getElementById("previewdeletedlastname").innerHTML = response['record']['title'];
            document.getElementById("previewdeletedexperttitle").innerHTML = response['record']['name'];
            document.getElementById("previewdeletedexpertdesc").innerHTML = response['record']['title'];
        }, statusCode: {}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
}
function forgot_password_reset()
{
    if (!isforgetpasswordValid())
    {
        var password = $('#newpassword').val().trim();
        var emailid = $('#email').html();
        var token = $('#consumerid').html();
        function formToJSON()
        {
            return JSON.stringify({"new_password": password, "email_id": emailid, "code": token});
        }
        $.ajax({type: "PUT", async: false, url: apibaseurlString + 'consumers/performpasswordreset/', data: formToJSON(), dataType: 'json', success: function (data)
            {
                if (data["type"] == "success")
                {
                    showsuccess();
                    document.getElementById("successMsg").innerHTML = "Your password has been changed successfully";
                    document.getElementById('resetform').style.display="none";
                    document.getElementById('newpassword').disabled = true;
                    document.getElementById('confirmpassword').disabled = true;
                    document.getElementById('save_btn').disabled = true;
                    return;
                } else
                {
                    showAlert();
                    document.getElementById("alertMsg").innerHTML = "Link has been expired";
                    document.getElementById('newpassword').disabled = true;
                    document.getElementById('confirmpassword').disabled = true;
                    document.getElementById('save_btn').disabled = true;
                }
            }, statusCode: {}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function isforgetpasswordValid()
{
    var ret_val = 1;
    var password = document.getElementById("newpassword").value.trim();
    var confirm_password = document.getElementById("confirmpassword").value.trim();
    if (password == "" || password == null)
    {
        showpasswordresetAlert();
        document.getElementById("forgotpassworderrormsg").innerHTML = "Enter Password";
        document.getElementById("newpassword").focus();
        ret_val = 1;
    } else if (password.length < 6)
    {
        showpasswordresetAlert();
        document.getElementById("forgotpassworderrormsg").innerHTML = "Password must be at least 6 characters in length";
        document.getElementById("newpassword").focus();
        ret_val = 1;
    } else if (confirm_password == "" || confirm_password == null)
    {
        showpasswordresetAlert();
        document.getElementById("forgotpassworderrormsg").innerHTML = "Confirm the Password";
        document.getElementById("confirmpassword").focus();
        ret_val = 1;
    } else if (password != confirm_password)
    {
        showpasswordresetAlert();
        document.getElementById("forgotpassworderrormsg").innerHTML = "Password Does not Match";
        document.getElementById("confirmpassword").focus();
        ret_val = 1;
    } else if (password == confirm_password)
    {
        hidepasswordresetAlert();
        ret_val = 0;
    }
    return ret_val;
}
function showpasswordresetAlert()
{
    document.getElementById("forgotpassworderrormsg").style.display = "block";
    document.getElementById("errordiv").style.display = "block";
}
function hidepasswordresetAlert()
{
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("forgotpassworderrormsg").style.display = "none";
}
function htmlspecialchars(str)
{
    if (typeof (str) == "string")
    {
        str = str.replace(/&/g, "&amp;");
        str = str.replace(/"/g, "&quot;");
        str = str.replace(/'/g, "&#039;");
        str = str.replace(/</g, "&lt;");
        str = str.replace(/>/g, "&gt;");
    }
    return str;
}
function htmlspecialchars_decode(str)
{
    if (typeof (str) == "string")
    {
        str = str.replace(/&gt;/ig, ">");
        str = str.replace(/&lt;/ig, "<");
        str = str.replace(/&#039;/g, "'");
        str = str.replace(/&quot;/ig, '"');
        str = str.replace(/&amp;/ig, '&');
    }
    return str;
}
function ajaxcall(type, sync, apiurl, datatosend, typeofdata)
{
    var responsedata = null;
    $.ajax({type: type, async: sync, url: apiurl, data: datatosend, dataType: typeofdata, success: function (data)
        {
            responsedata = data;
        }, statusCode: {}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
    return responsedata;
}
function ajaxerrors(jqXHR, exception)
{
    if (jqXHR.status === 0)
    {
    } else if (jqXHR.status == 404)
    {
        alert(' error Requested page not found. [404]');
    } else if (jqXHR.status == 500)
    {
        alert('Internal Server Error [500]');
    } else if (exception === 'parsererror')
    {
        alert('Requested JSON parse failed.');
    } else if (exception === 'timeout')
    {
        alert('Time out error.');
    } else if (exception === 'abort')
    {
        alert('Ajax request aborted.');
    } else
    {
        alert('Uncaught Error.\n' + jqXHR.responseText);
    }
}
function pushmessage()
{
    var msg = document.getElementById("pushmessagetext");
    if (!validmessageformdata())
    {
        function formToJSON()
        {
            return JSON.stringify({"message": $('#pushmessagetext').val().trim()});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = true;
        var url = apibaseurlString + 'publishpushnotification';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        showsuccess();
        hidemessagepreviewForm();
        document.getElementById("pushmessagetext").value = "";
    }
}
function pushconfirmation()
{
    hidesuccess();
    if (!validmessageformdata())
    {
        hideAlert();
        pushmessagepreview();
        showmessagepreviewForm();
    }
    var msg = document.getElementById("pushmessagetext");
    var preview = document.getElementById("previewmessage");
}
function validmessageformdata()
{
    var ret_val = 0;
    var message = $("#pushmessagetext").val().trim();
    if (message == "" || message == null)
    {
        document.getElementById("alertMsg").innerHTML = "Enter the Message to push";
        showAlert();
        $("#pushmessagetext").focus();
        ret_val = 1;
    }
    return ret_val;
}
function pushmessagepreview()
{
    document.getElementById("previewmessage").innerHTML = $('#pushmessagetext').val().trim();
}
function showmessagepreviewForm()
{
    $('.audvisor-pushmessage-preview-modal').modal('show');
}
function hidemessagepreviewForm()
{
    $('.audvisor-pushmessage-preview-modal').modal('hide');
}
function expertreenable(expertid)
{
    $.ajax({type: "GET", async: false, url: apibaseurlString + 'experts/' + expertid + '/deleted', data: null, dataType: 'json', success: function (data)
        {
            set_deleted_expertpreview(data);
            deleted_expert_preview();
        }, statusCode: {}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
}
function set_deleted_expertpreview(data)
{
    document.getElementById("dpreviewexpertname").innerHTML = data['firstname'];
    document.getElementById("dpreviewmiddlename").innerHTML = data['middlename'];
    document.getElementById("dpreviewlastname").innerHTML = data['lastname'];
    document.getElementById("dpreviewexperttitle").innerHTML = data['title'];
    document.getElementById("dpreviewpromotitle").innerHTML = data['expert_promo_title'];
    document.getElementById("dpreviewexpertdesc").innerHTML = data['expert_bio'];
    document.getElementById("expiddel").innerHTML = data['id'];
    var image_2x = data['avatar_link_2x'];
    var bioimg = data['expert_bio_image'];
    var thumbimg = data['expert_thumbnail_image'];
    var promoimg = data['expert_promo_image'];
    $("#dpimage").attr("src", image_2x);
    if (bioimg != "" || bioimg != null)
    {
        $("#dpbioimage").attr("src", bioimg);
    }
    if (thumbimg != "" || thumbimg != null)
    {
        $("#dpthumbnailimage").attr("src", thumbimg);
    }
    if (promoimg != "" || promoimg != null)
    {
        $("#dppromoimage").attr("src", promoimg);
    }
}
function deleted_expert_preview()
{
    $('.audvisor-deleted_expert-preview-modal').modal('show');
}
function hide_deleted_expert_preview()
{
    $('.audvisor-deleted_expert-preview-modal').modal('hide');
}
function re_enable_expert(formid)
{
    var expertid = $('#expiddel').html();
    $.ajax({type: "POST", async: false, url: apibaseurlString + 'experts/' + expertid + '/reenable', data: null, dataType: 'json', success: function (data)
        {
            try
            {
                document.getElementById("successMsg").innerHTML = "Expert Re-enabled Successfully";
                document.getElementById("images").value = "";
                document.getElementById("expertvoiceover").value = "";
                showsuccess();
                hideexpertpreviewForm();
                hideExpertformAlert();
                if (formid)
                {
                    var selection = document.getElementById("expid");
                    var option = document.createElement("option");
                    option.value = data["records"]["expert_id"];
                    option.text = data["records"]["expert_name"];
                    selection.appendChild(option);
                    $('#expid').multiselect('rebuild');
                    $('#expid').multiselect('select', data["records"]["expert_id"]);
                    $('#expid').multiselect('refresh');
                    hideExpertaddForm();
                } else
                {
                    hideexpertform();
                }
                hide_deleted_expert_preview();
            } catch (error)
            {
                alert("Error:" + error);
            }
        }, statusCode: {}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
}
function reg_new_expert(formid)
{
    var fId = "regform1";
    document.getElementById("btneditexpert").disabled = true;
    var expertbio = $('#expdesc').val().trim();
    var experttitle = $('#exptitle').val().trim();
    var promotitle = $('#promotitle').val().trim();
    var prefix = $('#expprefix').val().trim();
    function formToJSON()
    {
        var avatarPath = $('#images').val();
        return JSON.stringify({"name": $('#expname').val().trim(), "title": experttitle, "middlename": $('#expmiddlename').val().trim(), "lastname": $('#explastname').val().trim(), "description": expertbio, "promotitle": promotitle, "rating": $('#exprating').val().trim(), "prefix": prefix});
    }
    $.ajax({type: "POST", async: false, url: apibaseurlString + 'experts/regnew', data: formToJSON(), dataType: 'json', success: function (data)
        {
            alert(data["status"]);
            var fId = "regform1";
            uploadexprtsvoiceoverAudio(fId, data["records"]["expert_id"]);
            if (isexpertimageselected())
            {
                uploadLogo(fId, data["records"]["expert_id"]);
            }
            try
            {
                document.getElementById("successMsg").innerHTML = "Expert added successfully";
                document.getElementById("images").value = "";
                document.getElementById("expertvoiceover").value = "";
                showsuccess();
                hideexpertpreviewForm();
                hideExpertformAlert();
                if (formid)
                {
                    var selection = document.getElementById("expid");
                    var option = document.createElement("option");
                    option.value = data["records"]["expert_id"];
                    option.text = data["records"]["expert_name"];
                    selection.appendChild(option);
                    $('#expid').multiselect('rebuild');
                    $('#expid').multiselect('select', data["records"]["expert_id"]);
                    $('#expid').multiselect('refresh');
                    hideExpertaddForm();
                } else
                {
                    hideexpertform();
                }
                hide_deleted_expert_preview();
            } catch (error)
            {
                alert("Error:" + error);
            }
        }, statusCode: {}, error: function (jqXHR, exception)
        {
            ajaxerrors(jqXHR, exception);
        }});
}
function cmsresetpassword()
{
    var old_password = document.getElementById("CurrentPassword").value.trim();
    var new_password = document.getElementById("NewPassword").value.trim();
    var confirm_password = document.getElementById("ConfirmPassword").value.trim();
    if (!ispasswordformvalid())
    {
        if (new_password == confirm_password)
        {
            function formToJSON()
            {
                return JSON.stringify({"user_id": $("#uname").val(), "new_password": new_password, "old_password": old_password});
            }
            var datatosend = formToJSON();
            var type = "POST";
            var sync = false;
            var apiurl = cmsbaseurlString + 'passwordreset';
            var typeofdata = 'json';
            var data = ajaxcall(type, sync, apiurl, datatosend, typeofdata);
            if (data['type'] == 'success')
            {
                hideAlert();
                showsuccess();
                document.getElementById("successMsg").innerHTML = "Password Changed Successfully";
                clearpasswordresetform();
            } else if (data['type'] == 'error')
            {
                hidesuccess();
                showAlert();
                document.getElementById("alertMsg").innerHTML = "Password Does not match";
                clearpasswordresetform();
            }
        }
    }
}
function ispasswordformvalid()
{
    var ret_val = 0;
    var old_password = document.getElementById("CurrentPassword").value.trim();
    var new_password = document.getElementById("NewPassword").value.trim();
    var confirm_password = document.getElementById("ConfirmPassword").value.trim();
    if (old_password === "" || old_password === null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter Current Password";
        document.getElementById("CurrentPassword").focus();
        ret_val = 1;
    } else if (new_password === "" || new_password === null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter New Password";
        document.getElementById("NewPassword").focus();
        ret_val = 1;
    } else if (confirm_password === "" || confirm_password === null)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Confirm the Password";
        document.getElementById("ConfirmPassword").focus();
        ret_val = 1;
    } else if (confirm_password !== new_password)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "New Password and Confirm Password  does not match";
        document.getElementById("ConfirmPassword").focus();
        ret_val = 1;
    }
    return ret_val;
}
function clearpasswordresetform()
{
    document.getElementById("CurrentPassword").value = "";
    document.getElementById("NewPassword").value = "";
    document.getElementById("ConfirmPassword").value = "";
}
function clear_fileinputs()
{
    document.getElementById("images").value = "";
    document.getElementById("bioimage").value = "";
    document.getElementById("thumbnailimage").value = "";
    document.getElementById("promoimage").value = "";
    document.getElementById("expertvoiceover").value = "";
}
function forgot_password_cancel()
{
    document.getElementById("newpassword").value = "";
    document.getElementById("confirmpassword").value = "";
    hideAlert();
    hidesuccess();
}
function hideexpertweight()
{
    hidesettingsAlert('alertMsgexpertweight');
    document.getElementById("fldexpertweighting").value = "";
    $('.audvisor-expertweight-edit-modal').modal('hide');
}
function hidefirstweight()
{
    hidesettingsAlert('alertMsgfirstweight');
    document.getElementById("fldfirstmostlistenedweight").value = "";
    $('.audvisor-firstweight-edit-modal').modal('hide');
}
function hidesecondweight()
{
    hidesettingsAlert('alertMsgsecondweight');
    document.getElementById("fldsecondmostlistenedweight").value = "";
    $('.audvisor-secondweight-edit-modal').modal('hide');
}
function hidethirdweight()
{
    hidesettingsAlert('alertMsgthirdweight');
    document.getElementById("fldthirdmostlistenedweight").value = "";
    $('.audvisor-thirdweight-edit-modal').modal('hide');
}
function hidefourthweight()
{
    hidesettingsAlert('alertMsgfourthweight');
    document.getElementById("fldfourthmostlistenedweight").value = "";
    $('.audvisor-fourthweight-edit-modal').modal('hide');
}
function hideinsightcount()
{
    hidesettingsAlert('alertMsginsightcount');
    document.getElementById("fldrecommendedinsightlimit").value = "";
    $('.audvisor-insightcount-edit-modal').modal('hide');
}
function hideinsightweight()
{
    document.getElementById("fldinsightweighting").value = "";
    $('.audvisor-insightweight-edit-modal').modal('hide');
}
function isinsightweightValid()
{
    var retVal = 0;
    hidesuccess();
    var insightweight = $("#fldinsightweighting").val().trim();
    if (insightweight == null || insightweight == "")
    {
        showAlert1();
        hidesuccess();
        document.getElementById("alertMsg1").innerHTML = "Enter Insight Weight";
        document.getElementById("fldinsightweighting").focus();
        retVal = 1;
    }
    return retVal;
}
function showsettingsAlert(id, message)
{
    document.getElementById(id).style.display = "block";
    document.getElementById(id).innerHTML = message;
}
function hidesettingsAlert(id)
{
    document.getElementById(id).style.display = "none";
    document.getElementById(id).innerHTML = "";
}
function isexpertweightValid()
{
    var retVal = 0;
    hidesuccess();
    var expertweight = $("#fldexpertweighting").val().trim();
    if (expertweight == null || expertweight == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsgexpertweight', "Enter Expert Weight");
        document.getElementById("fldexpertweighting").focus();
        retVal = 1;
    }
    return retVal;
}
function isfirstweightValid()
{
    var retVal = 0;
    hidesuccess();
    var firstweight = $("#fldfirstmostlistenedweight").val().trim();
    if (firstweight == null || firstweight == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsgfirstweight', "Enter  value");
        document.getElementById("fldfirstmostlistenedweight").focus();
        retVal = 1;
    }
    return retVal;
}
function issecondweightValid()
{
    var retVal = 0;
    hidesuccess();
    var secondweight = $("#fldsecondmostlistenedweight").val().trim();
    if (secondweight == null || secondweight == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsgsecondweight', "Enter Value");
        document.getElementById("fldsecondmostlistenedweight").focus();
        retVal = 1;
    }
    return retVal;
}
function isthirdweightValid()
{
    var retVal = 0;
    hidesuccess();
    var thirdweight = $("#fldthirdmostlistenedweight").val().trim();
    if (thirdweight == null || thirdweight == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsgthirdweight', "Enter Value");
        document.getElementById("fldthirdmostlistenedweight").focus();
        retVal = 1;
    }
    return retVal;
}
function isfourthweightValid()
{
    var retVal = 0;
    hidesuccess();
    var fourthweight = $("#fldfourthmostlistenedweight").val().trim();
    if (fourthweight == null || fourthweight == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsgfourthweight', "Enter Value");
        document.getElementById("fldfourthmostlistenedweight").focus();
        retVal = 1;
    }
    return retVal;
}
function isinsightcountValid()
{
    var retVal = 0;
    hidesuccess();
    var insightlimit = $("#fldrecommendedinsightlimit").val().trim();
    if (insightlimit == null || insightlimit == "")
    {
        hidesuccess();
        showsettingsAlert('alertMsginsightcount', "Enter Insight Limit");
        document.getElementById("fldrecommendedinsightlimit").focus();
        retVal = 1;
    } else if (insightlimit < 10)
    {
        hidesuccess();
        showsettingsAlert('alertMsginsightcount', "Insight Limit  cannot be < 10 ");
        document.getElementById("fldrecommendedinsightlimit").focus();
        retVal = 1;
    }
    return retVal;
}
function showpreviewmodal(modalid)
{
    $(modalid).modal('show');
}
function hidepreviewmodal(modalid)
{
    $(modalid).modal('hide');
}
function insightweightpreview()
{
    document.getElementById("previewinsightweight").innerHTML = $('#fldinsightweighting').val().trim();
}
function expertweightpreview()
{
    document.getElementById("previewexpertweight").innerHTML = $('#fldexpertweighting').val().trim();
}
function firstweightpreview()
{
    document.getElementById("previewfirstweight").innerHTML = $('#fldfirstmostlistenedweight').val().trim();
}
function secondweightpreview()
{
    document.getElementById("previewsecondweight").innerHTML = $('#fldsecondmostlistenedweight').val().trim();
}
function thirdweightpreview()
{
    document.getElementById("previewthirdweight").innerHTML = $('#fldthirdmostlistenedweight').val().trim();
}
function fourthweightpreview()
{
    document.getElementById("previewfourthweight").innerHTML = $('#fldfourthmostlistenedweight').val().trim();
}
function insightlimitpreview()
{
    document.getElementById("previewinsightlimit").innerHTML = $('#fldrecommendedinsightlimit').val().trim();
}
function insightweightconfirm()
{
    if (!isinsightweightValid())
    {
        hideTopicAlert();
        insightweightpreview();
        showpreviewmodal('.audvisor-insightweight-editpreview-modal');
    }
}
function expertweightconfirm()
{
    if (!isexpertweightValid())
    {
        hideTopicAlert();
        expertweightpreview();
        showpreviewmodal('.audvisor-expertweight-editpreview-modal');
    }
}
function firstweightconfirm()
{
    if (!isfirstweightValid())
    {
        hideTopicAlert();
        firstweightpreview();
        showpreviewmodal('.audvisor-firstweight-editpreview-modal');
    }
}
function secondweightconfirm()
{
    if (!issecondweightValid())
    {
        hideTopicAlert();
        secondweightpreview();
        showpreviewmodal('.audvisor-secondweight-editpreview-modal');
    }
}
function thirdweightconfirm()
{
    if (!isthirdweightValid())
    {
        hideTopicAlert();
        thirdweightpreview();
        showpreviewmodal('.audvisor-thirdweight-editpreview-modal');
    }
}
function fourthweightconfirm()
{
    if (!isfourthweightValid())
    {
        hideTopicAlert();
        fourthweightpreview();
        showpreviewmodal('.audvisor-fourthweight-editpreview-modal');
    }
}
function insightcountconfirm()
{
    if (!isinsightcountValid())
    {
        hideTopicAlert();
        insightlimitpreview();
        showpreviewmodal('.audvisor-insightlimit-editpreview-modal');
    }
}
function cancelinsightweightpreview()
{
    hidepreviewmodal('.audvisor-insightweight-editpreview-modal');
}
function cancelexpertweightpreview()
{
    hidepreviewmodal('.audvisor-expertweight-editpreview-modal');
}
function cancelfirstweightpreview()
{
    hidepreviewmodal('.audvisor-firstweight-editpreview-modal');
}
function cancelsecondweightpreview()
{
    hidepreviewmodal('.audvisor-secondweight-editpreview-modal');
}
function cancelthirdweightpreview()
{
    hidepreviewmodal('.audvisor-thirdweight-editpreview-modal');
}
function cancelfourthweightpreview()
{
    hidepreviewmodal('.audvisor-fourthweight-editpreview-modal');
}
function cancelinsightcountpreview()
{
    hidepreviewmodal('.audvisor-insightlimit-editpreview-modal');
}
function updatesettings(id)
{
    var insightweight = document.getElementById(id).value;
    function formToJSON()
    {
        return JSON.stringify({"fldsettingsvalue": insightweight, "fldsettingsname": id});
    }
    var datatosend = formToJSON();
    var type = "POST";
    var sync = false;
    var url = apibaseurlString + 'generalsettings';
    var typeofdata = 'json';
    var data = ajaxcall(type, sync, url, datatosend, typeofdata);
    location.reload();
}
function filterinsights()
{
    var topic = $("#topiclist option:selected").text();
    var rows = $("#topinsight").find("tr");
    if (topic == "All")
    {
        rows.show();
        return;
    }
    rows.hide();
    rows.filter(function ()
    {
        var $t = $(this);
        var $t = $(this).find('td.topic');
        for (var d = 0; d < topic.length; ++d)
        {
            if ($t.is(":contains('" + topic + "')"))
            {
                return true;
            }
        }
        return false;
    }).show();
}
function promocodeconfirmation()
{
    if (!isAddPromocodeValid())
    {
        hideAlert();
        promocodepreview();
        showpromopreviewform();
    }
}
function promocodepreview()
{
    document.getElementById("previewpromocode").innerHTML = $('#promocode').val().trim();
    var startdate = document.getElementById("startdate").value;
    var enddate = document.getElementById("enddate").value;
    document.getElementById("previewstartdate").innerHTML = startdate;
    document.getElementById("previewenddate").innerHTML = enddate;
}
function showpromopreviewform()
{
    $('.audvisor-promocode-preview-modal').modal('show');
}
function hidepromopreviewform()
{
    $('.audvisor-promocode-preview-modal').modal('hide');
}
function isAddPromocodeValid()
{
    var retVal = 0;
    hidesuccess();
    var promocode = $("#promocode").val().trim();
    var startdate = $("#startdate").val().trim();
    var enddate = $("#enddate").val().trim();
    var date1 = $("#enddate").datepicker("getDate")
    var date2 = $("#startdate").datepicker("getDate")
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    if (promocode == null || promocode == "")
    {
        showAlert();
        hidesuccess();
        document.getElementById("alertMsg").innerHTML = "Enter 15 digit Promocode";
        document.getElementById("promocode").focus();
        retVal = 1;
    } else if (date2 > date1)
    {
        showAlert();
        hidesuccess();
        document.getElementById("alertMsg").innerHTML = "End Date should be greater than or equal to  Start Date ";
        document.getElementById("enddate").focus();
        retVal = 1;
    } else if (date1 < today)
    {
        showAlert();
        hidesuccess();
        document.getElementById("alertMsg").innerHTML = "End Date should be greater than or equal to  Today  ";
        document.getElementById("enddate").focus();
        retVal = 1;
    }
    return retVal;
}
function gettoday()
{
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10)
    {
        dd = '0' + dd
    }
    if (mm < 10)
    {
        mm = '0' + mm
    }
    var today = yyyy + '-' + mm + '-' + dd;
    return today;
}
function addpromocode()
{
    var promocode = $("#promocode").val().trim();
    var startdate = $("#startdate").val().trim() + " 00:00:00";
    var enddate = $("#enddate").val().trim() + " 00:00:00";
    if (!isAddPromocodeValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"promo_code": promocode, "start_date": startdate, "end_date": enddate});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = false;
        var url = apibaseurlString + 'promocode';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data["status"] == 1)
        {
            alert('Promocode already exists ');
        } else
        {
            document.getElementById("alertMsg").style.display = "none";
            document.getElementById("successMsg").innerHTML = "Promo Code added successfully";
            showsuccess();
            hidepromopreviewform()
        }
        document.getElementById('promocode').value = "";
        document.getElementById("startdate").value = gettoday();
        document.getElementById("enddate").value = gettoday();
    }
}
function onpromocodeEditBtnClick(id, promocode, startdate, enddate)
{
    var tempstartdate = startdate.split(" ");
    var tempenddate = enddate.split(" ");
    document.getElementById("promocode").value = promocode.trim();
    document.getElementById("startdate").value = tempstartdate[0];
    document.getElementById("enddate").value = tempenddate[0];
    document.getElementById("promocode").focus();
    document.getElementById("promocodeid").value = id;
    hideAlert();
    showEditPromo();
}
function showEditPromo()
{
    $('.modal audvisor-promocode-edit-modal').modal('show');
}
function hidepromoeditForm()
{
    $('.audvisor-promocode-edit-modal').modal('hide');
}
function editpromocode()
{
    var promocode = $("#promocode").val().trim();
    var promocodeid = $("#promocodeid").val().trim();
    var startdate = $("#startdate").val().trim() + " 00:00:00";
    var enddate = $("#enddate").val().trim() + " 00:00:00";
    if (!isAddPromocodeValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"promo_code": promocode, "start_date": startdate, "end_date": enddate});
        }
        var datatosend = formToJSON();
        var type = "PUT";
        var sync = false;
        var url = apibaseurlString + 'promocode/' + promocodeid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data["status"] == 1)
        {
            alert('Error in editing promocode ');
        } else
        {
            document.getElementById("alertMsg").style.display = "none";
            document.getElementById("successMsg").innerHTML = "Promo Code added successfully";
            hidepromoeditForm();
            showsuccess();
            hidepromopreviewform()
        }
        document.getElementById('promocode').value = "";
        document.getElementById("startdate").value = gettoday();
        document.getElementById("enddate").value = gettoday();
        location.reload();
    }
}
function onPromocodeDeleteBtnClick(promocodeid)
{
    var confirmVal = confirm("Are you sure you want to delete this Promo code ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        var datatosend = null;
        var type = "delete";
        var sync = false;
        var url = apibaseurlString + 'promocode/' + promocodeid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data['status'] == 1)
        {
            alert('This promocode is being used by user(s). Hence it could not be deleted');
            return 0;
        }
        if (data['status'] == 2)
        {
            alert('Error occured while deleting');
            return 0;
        }
        location.reload();
    }
}
function letternumber(e)
{
    var key;
    var keychar;
    if (window.event)
    {
        key = window.event.keyCode;
    } else if (e)
    {
        key = e.which;
    } else
    {
        return true;
    }
    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27))
    {
        return true;
    } else if ((("abcdefghijklmnopqrstuvwxyz0123456789").indexOf(keychar) > -1))
    {
        return true;
    } else
    {
        return false;
    }
}
function unescapeHTML(escapedHTMLtext)
{
    return escapedHTMLtext.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&amp;/g, '&').replace(/&quot;/g, '"').replace(/&#039;/g, "'");
}

function playlistconfirmation(isplaylist)
{
    if (!isAddPlaylistValid())
    {
        hidePlaylistAlert();
        $('#btnAddplaylist').removeAttr("disabled");
        playlistpreview();
        showplaylistpreviewform();
        if (isplaylist)
        {
            hideplaylistmodalform();
            showplaylistpreviewmodal();
        }
    }
}
function showplaylistpreviewform()
{
    $('.audvisor-playlist-preview-modal').modal('show');
}

function hideplaylistpreviewform()
{
    $('.audvisor-playlist-preview-modal').modal('hide');
}

function playlisteditconirmation()
{
    if (!isUpdatePlaylistValid())
    {
        playlisteditpreview();
        showplaylistpreviewform();
    }

}

function playlistpreview()
{
    document.getElementById("previewplaylistname").innerHTML = $('#playlistname').val().trim();
    
    if($('#listorder').length > 0) {
        document.getElementById("previewlistorder").innerHTML = $('#listorder').val().trim();
    }
}

function hidePlaylistAlert()
{
    document.getElementById("alertMsg1").style.display = "none";
}

function isAddPlaylistValid()
{
    var retVal = 0;
    hidesuccess();
    var playlistName = $("#playlistname").val().trim();
    if (playlistName == null || playlistName == "")
    {
        showAlert1();
        hidesuccess();
        document.getElementById("alertMsg1").innerHTML = "Enter PlayList name";
        document.getElementById("playlistname").focus();
        retVal = 1;
    }
    return retVal;
}

function addPlaylist(formid)
{
    var playlistName = document.getElementById("playlistname").value;
    //document.getElementById("btnAddplaylist").disabled = true;
    if (!isAddPlaylistValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"playlist_name": playlistName});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = false;
        var url = apibaseurlString + 'addPlayList';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);


        var fId = "newplaylistAddForm";
        document.getElementById("alertMsg1").style.display = "none";
        document.getElementById("successMsg").innerHTML = "playlist added successfully";
        showsuccess();
        if (formid)
        {
            var selection = document.getElementById("playlistid");
            var option = document.createElement("option");
            option.value = data["records"]["playlist_id"];
            option.text = data["records"]["playlist_name"];
            selection.appendChild(option);
            $('#playlistid').multiselect('rebuild');
            $('#playlistid').multiselect('select', data["records"]["playlist_id"]);
            hideaddplaylist();
        } else
        {
            document.getElementById("playlistname").value = "";
            hideplaylistpreviewform();
        }

    }
}

function onPlayListEditBtnClick(id, name, listorder, image)
{
    document.getElementById("eplaylistname").value = name.trim();
    document.getElementById("elistorder").value = listorder;
    document.getElementById("playlistid").value = id;
    document.getElementById("eplaylistname").focus();
    hidePlayListAlert();
    showEditPlayList();
}

function hidePlayListAlert()
{
    document.getElementById("alertMsg1").style.display = "none";
}
function showEditPlayList()
{
    document.getElementById("newplaylistEdit").style.display = "block";
    document.getElementById("eplaylistname").focus();
    hidePlayListAlert();
}
function getPlayListstat()
{
    var data = getstatistics();
    var z = 0;
    if (data['insightcount'])
    {
        z = data['insightcount'] / data['topiccount'];
    }
    var str = data['topiccount'] + "  topics with " + data['insightcount'] + "  insights " + "(Average " + z.toFixed(2) + " insights per topic)";
    updateStatistics(str);
}
function isUpdatePlaylistValid()
{
    var retVal = 0;
    var playlistName = document.forms["newplaylistEditForm"]["eplaylistname"].value.trim();
    if (playlistName == null || playlistName == "")
    {
        showAlert1();
        document.getElementById("alertMsg1").innerHTML = "Enter PlayList Name";
        document.getElementById("eplaylistname").focus();
        retVal = 1;
    }
    return retVal;
}
function playlisteditpreview()
{
    document.getElementById("previewplaylistname").innerHTML = $('#eplaylistname').val().trim();
    if($('#elistorder').length > 0) {
        document.getElementById("previewlistorder").innerHTML = $('#elistorder').val().trim();
    }
}

function UpdatePlayList()
{
    var playlistName = document.forms["newplaylistEditForm"]["eplaylistname"].value.trim();
    var listorder = document.forms["newplaylistEditForm"]["elistorder"].value.trim();
    var playlistid = document.forms["newplaylistEditForm"]["playlistid"].value.trim();
    if (!isUpdatePlaylistValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"playlist_id": playlistid, "playlist_name": playlistName, "list_order":listorder});
        }
        $.ajax({type: "put", url: apibaseurlString + 'playlists/update/' + playlistid, data: formToJSON(), dataType: 'json', success: function (response)
            {
                if (response.status == 0)
                {
                    var fId = "newplaylistEditForm";
                    document.getElementById(response['playlist']['id']).innerHTML = response['playlist']['name'];
                    hidePlayListupdateForm();
                    hideplaylistpreviewform();
                    location.reload();
                } else if (response.status == 2)
                {
                    hideplaylistpreviewform();
                    alert("PlayList \"" + response.playlist_name + "\" exists." + " If you have previously deleted \"" + response.playlist_name + "\" kindly add it again");
                } else if (response.status == 3)
                {
                    location.reload();
                }
            }, statusCode: {200: function ()
                {
                    hidePlayListupdateForm();
                    hideplaylistpreviewform();
                    location.reload();
                }}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}

function hidePlayListupdateForm()
{
    document.getElementById("newplaylistEdit").style.display = "none";
    document.getElementById("eplaylistname").value = "";
    $('.audvisor-playlist-edit-modal').modal('hide');
}

function onPlayListDeleteBtnClick(playlistid)
{
    var confirmVal = confirm("Are you sure you want to delete this Playlist ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        var datatosend = null;
        var type = "put";
        var sync = false;
        var url = apibaseurlString + 'playlists/delete/' + playlistid;
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        location.reload();
    }
}

function showaddPlayList()
{
    hidesuccess();
    hidePlayListAlert();
    showplaylistmodalform();
    document.getElementById("newplaylistAdd").style.display = "block";
    document.getElementById("playlistname").value = "";
    document.getElementById("playlistname").focus();
}
function showplaylistmodalform()
{
    document.getElementById("playlistpreviewbutton").style.display = "none";
    document.getElementById("previewplaylistform").style.display = "none";
    document.getElementById("newplaylistAddForm").style.display = "block";
    document.getElementById("playlistaddbutton").style.display = "block";
}

function hideplaylistmodalform()
{
    document.getElementById("newplaylistAddForm").style.display = "none";
    document.getElementById("playlistaddbutton").style.display = "none";
}
function showplaylistpreviewmodal()
{
    document.getElementById("playlistpreviewbutton").style.display = "block";
    document.getElementById("previewplaylistform").style.display = "block";
}
function hideaddplaylist()
{
    document.getElementById("newplaylistAdd").style.display = "none";
    document.getElementById("playlistname").value = " ";
    $('.audvisor-playlist-add-modal').modal('hide');
}

function onPlayListViewBtnClick(playlistid) {
    var url = '/playlistInsightsView/' + playlistid;
    location.href = url;
}



function onPlayListInsightEditBtnClick(playlist_id, insight_id, insight_name,list_order)
{
    document.getElementById("playlistid").value = playlist_id;
    document.getElementById("playlistinsightid").value = insight_id;
    document.getElementById("eplaylistinsightname").innerHTML = insight_name.trim();
    document.getElementById("eplaylistinsightlistorder").value = list_order;
    document.getElementById("eplaylistinsightlistorder").focus();
    hidePlayListAlert();
    showEditPlayListInsight();
}
function showEditPlayListInsight()
{
    document.getElementById("newplaylistinsightEdit").style.display = "block";
    document.getElementById("eplaylistinsightlistorder").focus();
    hidePlayListAlert();
}

function playlistinsighteditconirmation()
{
    if (!isUpdatePlaylistinsightValid())
    {
        playlistinsighteditpreview();
        showplaylistinsightpreviewform();
    }

}
function isUpdatePlaylistinsightValid()
{
    var retVal = 0;
    var listorder = document.forms["newplaylistinsightEditForm"]["eplaylistinsightlistorder"].value.trim();
    if (listorder == null || listorder == "")
    {
        showAlert1();
        document.getElementById("alertMsg1").innerHTML = "Enter List order";
        document.getElementById("eplaylistinsightlistorder").focus();
        retVal = 1;
    }
    return retVal;
}
function playlistinsighteditpreview()
{
    document.getElementById("previewplaylistinsightname").innerHTML = $('#eplaylistinsightname').text().trim();
    document.getElementById("previewplaylistinsightlistorder").innerHTML = $('#eplaylistinsightlistorder').val().trim();
}
function showplaylistinsightpreviewform()
{
    $('.audvisor-playlist-insight-preview-modal').modal('show');
}
function hideplaylistinsightpreviewform()
{
    $('.audvisor-playlist-insight-preview-modal').modal('hide');
}

function UpdatePlayListInsightListOrder()
{
    var playlistid = document.forms["newplaylistinsightEditForm"]["playlistid"].value.trim();
    var playlistinsightid = document.forms["newplaylistinsightEditForm"]["playlistinsightid"].value.trim();
    var listorder = document.forms["newplaylistinsightEditForm"]["eplaylistinsightlistorder"].value.trim();
    
    if (!isUpdatePlaylistinsightValid())
    {
        function formToJSON()
        {
            return JSON.stringify({"playlist_id": playlistid, "playlist_insight_id": playlistinsightid, "list_order": listorder});
        }
        $.ajax({type: "put", url: apibaseurlString + 'playlists/updateListOrder/', data: formToJSON(), dataType: 'json', success: function (response)
            {
               if (response.status == 0)
                {
                    var fId = "newplaylistinsightEditForm";
                    document.getElementById(response['playlist']['id']).innerHTML = response['playlist']['name'];
                    hidePlayListInsightupdateForm();
                    hideplaylistinsightpreviewform();
                    location.reload();
                } else if (response.status == 2)
                {
                    hideplaylistinsightpreviewform();
                    alert("PlayList \"" + response.playlist_name + "\" exists." + " If you have previously deleted \"" + response.playlist_name + "\" kindly add it again");
                } else if (response.status == 3)
                {
                    location.reload();
                }

            }, statusCode: {200: function ()
                {
                    hidePlayListInsightupdateForm();
                    hideplaylistinsightpreviewform();
                    location.reload();
                }}, error: function (jqXHR, exception)
            {
                ajaxerrors(jqXHR, exception);
            }});
    }
}
function hidePlayListInsightupdateForm()
{
    document.getElementById("newplaylistinsightEdit").style.display = "none";
    document.getElementById("eplaylistinsightlistorder").value = "";
    $('.audvisor-playlist-insight-edit-modal').modal('hide');
}
function onPlayListInsightDeleteBtnClick(playlistid,playlistinsightid)
{
    var confirmVal = confirm("Are you sure you want to delete this Playlist ? \n \nPress OK to continue, or click Cancel to abort the deletion.");
    if (confirmVal == true)
    {
        function formToJSON()
        {
            return JSON.stringify({"playlist_id": playlistid, "playlist_insight_id": playlistinsightid});
        }
        var datatosend = formToJSON();
        var type = "put";
        var sync = false;
        var url = apibaseurlString + 'playlists/deletePlayListInsights/';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        location.reload();
    }
}
function markasfeatured(insight_id, expert_img, image_2x, isonline)
{
    var id1 = "isfeatured2" + insight_id;
    var tempid = "#" + id1;
    var x = 1;
    var row = "isfeaturedrow" + insight_id;
    if ((image_2x == null || image_2x == "") && (isfeatured == 0))
    {
        if ((expert_img == null || expert_img == "") && (isfeatured == 0))
        {
            var confirmVal = confirm("Expert's Profile Image Not Available. Are you sure you want to make this Insight as Featured? \n \nPress OK to continue, or click Cancel to abort the operation.");
            if (confirmVal != true)
            {
                $(tempid).removeAttr("disabled");
                x = 0;
            }
        }
    }
    if (x == 1)
    {
        function formToJSON()
        {
            return JSON.stringify({"insight_id": insight_id});
        }
        var datatosend = formToJSON();
        var type = "POST";
        var sync = false;
        var url = apibaseurlString + 'insights/' + insight_id + '/togglefeaturedinsight';
        var typeofdata = 'json';
        var data = ajaxcall(type, sync, url, datatosend, typeofdata);
        if (data["status"] == 1)
        {
            return;
        }
        getInsightstat();
        if (data['result'] == 1)
        {
            $(tempid).removeAttr("disabled");
            document.getElementById(id1).innerHTML = "Yes/No";
            document.getElementById(row).className = "success";
        } else if (data['result'] == 325)
        {
            alert("No streaming URL available this insight cannot be made as featured insight");
        } else if (data['result'] == 328)
        {
            alert("Already "+data['featured_insight_count']+" insights marked as featured. if you want to mark new insights as featured, then first mark any existing insight as un-featured");
        } else
        {
            $(tempid).removeAttr("disabled");
            document.getElementById(id1).innerHTML = "Yes/No";
            document.getElementById(row).className = "table-striped";
        }
        var table = $('#tableinsight').DataTable();
        table.ajax.reload(null, false);
    } else
    {
    }
}