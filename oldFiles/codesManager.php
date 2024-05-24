<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.min.css" integrity="sha512-yLNTU6YQWEtsM/WVkUqd2jRzzq5hmfFUMVvziVlkgC0R9HTElDtyF4DiWiBeMS36npvN+NWwrr764A4AWGcmQQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="icon" href="./icon.png" type="image/png">
    <title>🚦Server Config Manager</title>
    <style>
        body{
            background-color: rgb(46, 43, 43);
        }
        /* Style for cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 96%;
            margin: 2%;
            border-radius: 15px;
            background-color: #d8f0de15;
            border: 2px solid aqua;
        }

        /* Hover effect */
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        /* Card content */
        .container {
            padding: 1%;
        }
        textarea{
            width: 90%;
            border-radius: 15px;
            display: inline-block; /* Ensure inline-block for buttons alignment */
            vertical-align: middle; /* Align vertically */
            background-color: rgba(255, 255, 255, 0.466);
            color: greenyellow;
        }
        button{
            width:98%;
            min-height: 50px;
            background-color: transparent;
            border: 2px solid red;
            color: white;
            border-radius: 10px;
            box-shadow: 2px solid red;
            margin-top: 7%;
            margin-bottom: 7%;
        }
        input{
            min-height: 40px;
            text-align: center;
            width: 100%;
        }
        td{

        }
        a{
          font-size: small;
          margin-right: 5%;
        }
    </style>
</head>
<body>

<div id="main_div">
    <div class="card" style="display:none" id="tst">
        <div class="container">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 26%;">
                        <input type="text" name="" id="" placeholder="Config Name">
                            <button onclick="SaveConfig(this)" style="border-color:aquamarine">Save</button>
                            <button>Delete</button>
                        <input type="number" name="" id="" placeholder="order">
                    </td>
                    <td style="width: 74%; padding: 2%;" >
                        <textarea name="" id="" cols="30" rows="10" placeholder="Config contents" >vless://c07e8407-319d-4f37-e4be-a60051851111@es.kiyanstore.com:56425?path=%2F&security=none&encryption=none&type=ws#fin2</textarea>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>
<script type="text/javascript">

$( document ).ready(function() {
  GetAllConfigs();
  setTimeout(function () {
    const clipboardContent = pasteFromClipboard();

  }, 1000);
});
async function SaveConfig(caller){
  var card_holder = caller.parentNode.parentNode.parentNode.parentNode.parentNode;
  console.log(caller.parentNode.parentNode.parentNode.parentNode.parentNode);
  console.log(new Date().toISOString().slice(0, 10));
  var SortOrder = document.getElementById(card_holder.id+"_config_orderNumber_input").value
  var Name = document.getElementById(card_holder.id+"_config_name_input").value
  var Content = document.getElementById(card_holder.id+"_config_Content_input").value
  var Remark = new Date().toLocaleString('tr-TR', { timeZone: 'Europe/Istanbul' })
  console.log(SortOrder,Name,Content,Remark);

  $.ajax({
      url: './service.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        req:"save_config",
        Config_ID:card_holder.id,
        SortOrder:SortOrder,
        Name:Name,
        Content:Content,
        Remark:Remark,
      },
      success:async function(data_recived) {
        console.log(data_recived);
        if (data_recived['Add']) {
          GetAllConfigs()
        }else {
          alert('add error')
          alert(data_recived)
        }
        //To make a empty form
     }
  });
}
async function DelConfig(caller){
  var card_holder = caller.parentNode.parentNode.parentNode.parentNode.parentNode;
  $.ajax({
      url: './service.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        req:"del_config",
        Config_ID:card_holder.id,
      },
      success:async function(data_recived) {
        console.log(data_recived);

        if (data_recived['Del']) {
          GetAllConfigs()
        }else {
          alert('del error')
          alert(data_recived)
        }

        //To make a empty form
     }
  });
}
async function GetAllConfigs(){
  $.ajax({
      url: './service.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        req:"GetAllConfigs",
      },
      success:async function(data_recived) {
        console.log(data_recived);
        if (data_recived) {
          document.getElementById('main_div').innerHTML=""
          data_recived.sort((a, b) => a.SortOrder - b.SortOrder);
          for (var i = 0; i < data_recived.length; i++) {
            make_config_card(data_recived[i]['Name'],data_recived[i]['SortOrder'],data_recived[i]['Content'],data_recived[i]['Config_ID'])
          }
          //To make a empty form

        }
        make_config_card()
     }
  });
}
async function make_config_card(config_name="",config_order="",config_content="",Config_ID="NaN") {
    var card_div = document.createElement('div')
    card_div.className="card"
    card_div.id = parseInt(Config_ID)
    var card_container = document.createElement('div')
    card_container.className="container"
    var card_table = document.createElement('table')
    card_table.style="width:100%"
    var card_table_row=document.createElement('tr')
    var first_td = document.createElement('td')
    first_td.style="width: 26%;"
    var config_name_input = document.createElement('input')
    config_name_input.type="text"
    config_name_input.placeholder="Config Name"
    config_name_input.value=config_name
    config_name_input.id = Config_ID+"_config_name_input"
    config_name_input.setAttribute('onkeyup','manage_sameNameAsLabel(this)')
    var config_Save_button = document.createElement('button')
    config_Save_button.innerText="Save"
    config_Save_button.style.borderColor="aquamarine"
    config_Save_button.style.width="100%"
    config_Save_button.setAttribute('onclick','SaveConfig(this)')
    config_Save_button.id = Config_ID+"_config_Save_button"
    var config_Delete_button = document.createElement('button')
    config_Delete_button.innerText="Delete"
    config_Delete_button.style.borderColor="red"
    config_Delete_button.style.width="100%"
    config_Delete_button.setAttribute('onclick','DelConfig(this)')
    config_Delete_button.id = Config_ID+"_config_Delete_button"
    var config_orderNumber_input = document.createElement('input')
    config_orderNumber_input.type="number"
    config_orderNumber_input.placeholder="order"
    config_orderNumber_input.value=parseInt(config_order)
    config_orderNumber_input.id = Config_ID+"_config_orderNumber_input"

    var config_Paste_button = document.createElement('button')
    config_Paste_button.innerText="Clipboard Paste"
    config_Paste_button.style.borderColor="green"
    config_Paste_button.style.width="100%"
    config_Paste_button.style.fontSize="smaller"
    config_Paste_button.setAttribute('onclick','document.getElementById("'+Config_ID+'_config_Content_input").value=pasteFromClipboard()')
    config_Paste_button.addEventListener('click', function() {
      pasteFromClipboard().then(function(clipboardContent) {
          document.getElementById(Config_ID + '_config_Content_input').value = clipboardContent;
      }).catch(function(error) {
          console.error('Error pasting from clipboard:', error);
      });
    });
    config_Paste_button.id = Config_ID+"_config_Paste_button"

    var secound_td = document.createElement('td')
    secound_td.setAttribute('rowspan','2')
    secound_td.style.padding="2%"
    var config_Content_input = document.createElement('textarea')
    config_Content_input.cols=30
    config_Content_input.rows=10
    config_Content_input.placeholder="Config contents"
    config_Content_input.value=config_content
    config_Content_input.id = Config_ID+"_config_Content_input"






    first_td.appendChild(config_Paste_button)
    first_td.appendChild(config_name_input)
    first_td.appendChild(config_Save_button)
    first_td.appendChild(config_orderNumber_input)
    first_td.appendChild(config_Delete_button)


    secound_td.appendChild(config_Content_input)
    if (config_content.substring(0, 5)==="vmoss") {
      config_Content_input.rows = "7"
      var configlinkPreview = document.createElement('a')
      var listView_link = document.createElement('a')
      var listgenerator_link = document.createElement('a')
      listView_link.innerText = "Web Service"
      listgenerator_link.innerText = "Link Generator"

      deEncriptor(config_content).then(result => {
        configlinkPreview.innerText=result
        listView_link.href = "https://"+result+"/vpn/list.php"
        configlinkPreview.href = "https://"+result+"/vpn/linksManager.php"
        listgenerator_link.href = "https://"+result+"/vpn/code.php"
      });
      configlinkPreview.id = Config_ID+"_configlinkPreview"
      configlinkPreview.style="color: white;text-align:center;width:100%;"


      secound_td.appendChild(configlinkPreview)
      secound_td.appendChild(listView_link)
      secound_td.appendChild(listgenerator_link)
    }



    card_table_row.appendChild(first_td)
    card_table_row.appendChild(secound_td)

    card_table.appendChild(card_table_row)
    card_container.appendChild(card_table)
    card_div.appendChild(card_container)
    document.getElementById('main_div').appendChild(card_div)
}
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            console.log('Text copied to clipboard successfully');
        })
        .catch(err => {
            console.error('Unable to copy text to clipboard: ', err);
        });
}

async function deEncriptor(str) {
    var result=""

    if (str.substring(0,8)==="vmoss://") {
        str = str.substring(8)
        for (let i = 0; i < str.length; i+=3) {
            result +=str[2]
            str= str.substring(3)
            if (str.substring(0,2)==="99") {
                break
            }
        }
    }
    return result
}

function pasteFromClipboard() {
    return navigator.clipboard.readText()
        .then(clipboardText => {
            console.log('Text pasted from clipboard:', clipboardText);
            return clipboardText;
        })
        .catch(err => {
            console.error('Unable to paste text from clipboard: ', err);
            return '';
        });
}

async function manage_sameNameAsLabel(caller){;
    var card_holder = await caller.parentNode.parentNode.parentNode.parentNode.parentNode;
        if (document.getElementById(card_holder.id + '_config_Content_input').value.substring(0,8)==="vless://") {
            var contents = document.getElementById(card_holder.id + '_config_Content_input').value
            let lastHashPosition = contents.lastIndexOf('#');
            console.log(lastHashPosition);
            if (lastHashPosition !== -1) {
                const usabledContent = contents.substring(0, lastHashPosition)+"#";
                console.log("usabledContent : ______"+usabledContent);
                document.getElementById(card_holder.id + '_config_Content_input').value = usabledContent+document.getElementById(card_holder.id+'_config_name_input').value;
            }

        }
}

// Example usage:
pasteFromClipboard().then(clipboardContent => {
    console.log('Clipboard content:', clipboardContent);
});

</script>
