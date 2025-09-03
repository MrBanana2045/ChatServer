<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat Server</title>
<style>
#group {
    position: fixed;
    top: 0;
    left: -300px;
    width: 200px;
    height: 100%;
    background: #222;
    color: #fff;
    overflow-y: auto;
    padding: 10px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.5);
    z-index: 1001;
    transition: left 0.3s ease;
}
#chatPanel {
    position: fixed;
    top: 0;
    left: 0;
    width: calc(100% - 1px);
    height: 100%;
    background: #222;
    color: #fff;
    overflow-y: auto;
    padding: 10px;
    box-shadow: -2px 0 5px rgba(0,0,0,0.5);
    z-index: 999;
}
#messages {
    height: calc(100% - 130px);
    overflow-y: auto;
    margin-top: 10px;
    padding-bottom: 80px;
}
#messageForm {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #151515;
    padding: 10px;
    display: flex;
    z-index: 1000;
}
#messageForm input[type='text'] {
    flex: 1;
    padding: 5px;
    outline: none;
    background: #222;
    border: none;
    border-bottom: 2px solid #555;
    color:white;
}
#messageForm input[type='submit'] {
    padding: 5px 10px;
    background: none;
    border: none;
    border-bottom: 2px solid #555;
    font-size: 20px;
    color: #555;
}
.group-item {
    padding: 10px;
    margin: 5px 0;
    background: #333;
    border-radius: 4px;
    cursor: pointer;
}
#group.open {
    left: 0;
}
#group .close-btn-group {
    position: absolute;
    top: 18px;
    left: 10px;
    font-size: 20px;
    cursor: pointer;
    background: none;
    border: none;
    color: #fff;
}
.group-item:hover {
    background: #444;
}
.group-item.active {
    background: #555;
}
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  background: #aaa; 
}
 
::-webkit-scrollbar-thumb {
  background: #222; 
}
#userPanel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 300px;
    height: 100%;
    background: #222;
    color: #fff;
    overflow-y: auto;
    padding: 10px;
    box-shadow: -2px 0 5px rgba(0,0,0,0.5);
    z-index: 1001;
    transition: right 0.3s ease;
}
#userPanel.open {
    right: 0;
}
#userPanel h3 {
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #444;
}
#userPanel .close-btn {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 20px;
    cursor: pointer;
    background: none;
    border: none;
    color: #fff;
}
#userPanel .ip-list {
    margin-top: 20px;
}
#userPanel .ip-item {
    padding: 8px;
    margin: 5px 0;
    background: #333;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
}
#userPanel .ip-item .timestamp {
    color: #aaa;
    font-size: 12px;
}
#usr {
    cursor: pointer;
}
#showRip{
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height:100px;
    border-radius: 20px;
    background:#151515;
    padding: 10px;
    display: none;
}
#rip{
  background:#222;
  border-radius: 20px;
  padding: 10px;
  font-weight: 900;
  border-left: 2px solid #fff;
  display: flex;
}
.ser {
    margin-left: 30px;
}

@media (min-width: 769px) {
    #group {
        left: 0;
        border-right: 1px solid #444;
        z-index: 1000;
    }
    #userPanel {
        right: 0 !important;
        border-left: 1px solid #444;
        z-index: 1000;
    }
    
    #chatPanel {
        left: 218px !important;
        width: calc(100% - 540px) !important;
        z-index: 999;
    }
    
    #messages {
        height: calc(100% - 90px) !important;
    }
    
    .close-btn-group, .close-btn {
        display: none;
    }
    
    #server, #usr {
        display: none !important;
    }
    
    .chat-header {
        display: block !important;
    }
    
    #messageForm {
        left: 215px !important;
        width: calc(100% - 550px) !important;
    }
    
    #showRip {
        left: 215px !important;
        width: calc(100% - 555px) !important;
    }
}
.ip-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    padding: 5px;
}
.message-count {
    margin-top: -3px;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.9em;
}
.timestamp {
    color: #666;
    font-size: 0.8em;
}
</style>
</head>
<body>
    <code>
<div id="group">
    <button class="close-btn-group" onclick="toggleGroup()">✕</button>
    <h3 class="ser" style="border-bottom: 1px solid #444;">Servers</h3>
    <p id="add" style="float:right; margin-top: -40px; font-size: 20px;">✚</p>
    <div id="groupList" style="margin-top: 10px;"></div>
</div>
<div id="chatPanel">
    <div class="chat-header" style="background: #151515; margin-top:-10px; height:40px; margin-left:-8px; padding:10px; display:flex;">
    <p id='server' style="color:#fff; margin-left:10px; font-size: 20px; margin-top:8px; margin-right:10px;">☰</p>
    <h3 id="user"></h3> 
    <p id='usr' style="color:#fff; margin-top:8px; font-size: 20px; cursor: pointer; margin-left: auto; margin-right: 10px;">☰</p>
    </div>
    <div id="messages">Loading Message ...</div>
    <div id="showRip">
            <div id="rip"></div>
        </div>
    <form id="messageForm" method="POST" action="save.php">
        <input type="hidden" name="reply" id="replyInput" />
        <input type="hidden" name="group" id="currentGroup" value="" />
        <input type="text" name="msg" placeholder="Message ..." required />
        <input type="submit" value="➤" />
    </form>
</div>
<div id="userPanel">
    <button class="close-btn" onclick="toggleUserPanel()">✕</button>
    <h3 style="margin-left:40px; margin-top: 10px;" id="usrs"></h3>
    <div id="ipList" class="ip-list">
        <p>Loading users...</p>
    </div>
</div>

<script>
let currentGroup = null;
let userPanelOpen = false;
let groups = false;

function loadGroups() {
    fetch('load.php')
        .then(response => response.json())
        .then(data => {
            const groupList = document.getElementById('groupList');
            groupList.innerHTML = '';
            
            const userIp = '<?php echo $_SERVER["REMOTE_ADDR"]; ?>'.replace(/\./g, '_');
            
            data.groupName.forEach(groupName => {
                const groupItem = document.createElement('div');
                groupItem.className = 'group-item';
                const userCount = data.usersPerGroup[groupName] || 0;
                
                const groupContainer = document.createElement('div');
                groupContainer.style.display = 'flex';
                groupContainer.style.justifyContent = 'space-between';
                groupContainer.style.alignItems = 'center';
                
                const groupInfo = document.createElement('div');
                groupInfo.innerHTML = groupName + ' ' + '<p style="text-align:right; margin-top:-17px; font-size:15px; margin-right:-45px; margin-bottom:-2px;">♟' + userCount + '</p>';
                groupContainer.appendChild(groupInfo);
                
                if (groupName === userIp) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.textContent = '🅧';
                    deleteBtn.style = "background:none; border:none; color: white; font-size:20px; cursor: pointer; margin-left: 10px; margin-top:-2px;";
                    
                    deleteBtn.onclick = function(event) {
                        event.stopPropagation();
                        deleteServer(groupName);
                    };
                    
                    groupContainer.appendChild(deleteBtn);
                }
                
                groupItem.appendChild(groupContainer);
                
                groupItem.addEventListener('click', function() {
                    document.querySelectorAll('.group-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    this.classList.add('active');
                    currentGroup = groupName;
                    document.getElementById('currentGroup').value = groupName;
                    loadMessages();
                });
                
                groupList.appendChild(groupItem);
            });
            
            if (data.groupName.length > 0 && currentGroup === null) {
                currentGroup = data.groupName[0];
                document.getElementById('currentGroup').value = currentGroup;
                document.querySelector('.group-item').classList.add('active');
                loadMessages();
            }
        });
}

function deleteServer(groupName) {
    if (confirm('Are you sure you want to delete the server?')) {
        fetch('delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'group=' + encodeURIComponent(groupName)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadGroups();
                if (currentGroup === groupName) {
                    currentGroup = null;
                    document.getElementById('currentGroup').value = '';
                }
            }
        })
    }
}

function loadMessages() {
    if (!currentGroup) return;
    fetch(`load.php?group=${encodeURIComponent(currentGroup)}`)
        .then(response => response.json())
        .then(data => {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = '';
            document.getElementById('usrs').innerText = 'Members ' + data.ip;
            document.getElementById('user').innerText = 'Server ' + data.ip;
            data.messages.forEach(msg => {
                const isReplied = msg.includes('┏╼╼┫') || msg.includes('│') || msg.includes('┗╾╾┫');
                const isJoin = msg.includes('*');
                const messageEl = document.createElement('div');
                messageEl.className = 'message';
                messageEl.style.display = 'flex';
                messageEl.style.alignItems = 'center';

                const messageText = document.createElement('div');
                messageText.innerHTML = msg;
                messageText.style.flex = '1';
                const replyBtn = document.createElement('button');
                replyBtn.textContent = '↺';
                replyBtn.style.background = 'none';
                replyBtn.style.color = 'white';
                replyBtn.style.fontWeight = '900';
                replyBtn.style.border = 'none';
                replyBtn.style.borderLeft = '2px solid white';
                replyBtn.style.cursor = 'pointer';
                replyBtn.style.marginRight = '10px';
                replyBtn.style.marginBottom = '5px';
                messageEl.appendChild(messageText);
                messageEl.appendChild(replyBtn);
                replyBtn.onclick = () => {
                    document.getElementById('replyInput').value = msg;
                    document.querySelectorAll('.message button').forEach(btn => {
                        btn.disabled = false;
                        btn.style.display = 'inline-block';
                    });
                    replyBtn.disabled = true;
                    replyBtn.style.display = 'none';
                    showReplyPreview(msg);
                };
                if (isReplied || isJoin) {
                    replyBtn.style.display = 'none';
                }
                messagesDiv.appendChild(messageEl);
            });
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });
}

function toggleUserPanel() {
    if (window.innerWidth > 768) return;
    
    const userPanel = document.getElementById('userPanel');
    userPanelOpen = !userPanelOpen;
    
    if (userPanelOpen) {
        userPanel.classList.add('open');
    } else {
        userPanel.classList.remove('open');
    }
}
function toggleGroup() {
    if (window.innerWidth > 768) return;
    
    const group = document.getElementById('group');
    group.classList.toggle('open');
}


let previousUsers = [];
function loadUsers() {
    if (!currentGroup) return;
    fetch(`user.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `group=${encodeURIComponent(currentGroup)}`
    })
    .then(response => response.json())
    .then(data => {
        const ipList = document.getElementById('ipList');
        ipList.innerHTML = '';
        const currentUsers = [];
        
        if (data.users && data.users.length > 0) {
            data.users.forEach(user => {
                currentUsers.push(user.ip);
                const ipItem = document.createElement('div');
                ipItem.className = 'ip-item';
                
                const ipText = document.createElement('span');
                ipText.textContent = user.ip;
                
                const messageCount = document.createElement('span');
                messageCount.className = 'message-count';
                messageCount.textContent = `✉ ${user.msg}`;
                
                const timestamp = document.createElement('span');
                timestamp.className = 'timestamp';
                timestamp.textContent = user.last_seen;
                
                ipItem.appendChild(ipText);
                ipItem.appendChild(messageCount);
                ipItem.appendChild(timestamp);
                ipList.appendChild(ipItem);
            });
            
            const newUsers = currentUsers.filter(ip => !previousUsers.includes(ip));
            newUsers.forEach(newIp => {
                fetch(`save.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user=${encodeURIComponent(newIp)}&group=${encodeURIComponent(currentGroup)}`
                }).then(res => res.json());
            });
        } else {
            ipList.innerHTML = '<p>No users found.</p>';
        }
        previousUsers = currentUsers;
    });
}

setInterval(loadMessages, 2000);
setInterval(loadGroups, 2000);
setInterval(loadUsers, 2000);

document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (!currentGroup) return;
    
    const formData = new FormData(this);
    const messageInput = formData.get('message');
    fetch('save.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        document.getElementById('showRip').style.display = 'none';
        return response.json();
    })
    .then(data => {
        loadMessages();
        loadUsers();
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

function showReplyPreview(msg) {
    const ripDiv = document.getElementById('rip');
    ripDiv.innerHTML = '';
    const closeBtn = document.createElement('p');
    closeBtn.textContent = '✕';
    closeBtn.style.fontWeight = '900';
    closeBtn.style.marginTop = '-5px';
    closeBtn.style.marginRight = '10px';
    closeBtn.style.cursor = 'pointer';
    closeBtn.onclick = () => {
        document.getElementById('showRip').style.display = 'none';
        location.reload();
    };
    ripDiv.appendChild(closeBtn);
    const msgPara = document.createElement('p');
    msgPara.textContent = msg;
    ripDiv.appendChild(msgPara);
    document.getElementById('showRip').style.display = 'block';
}
document.getElementById('usr').addEventListener('click', toggleUserPanel);
document.getElementById('server').addEventListener('click', toggleGroup);
document.getElementById('add').addEventListener('click', function(e){
    fetch('server.php?group=${encodeURIComponent(currentGroup)}', {
        method: 'POST'
    })
    .then(response => response.text())
});

loadGroups();
</script>
</code>
</body>
</html>
