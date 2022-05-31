// log関与版
// typeof関数付き
export function log(i){
    console.log(i, typeof(i));
};

// logβ 複数の引数の場合
// 注意：引数が足りない場合、足りない分だけundefinedが表示
// 発見：引数が関数＝＞配列になっても問題なく処理された値が出力される
export function logS(a, b, c, d, e){
    const parameters = [a, b, c, d, e];
    for (let i=0; i<parameters.length; i++){
        console.log(parameters[i], typeof(parameters[i]));
    };
};

// inputされた内容がスペースだけかを確認
// 空白のみはTRUE && Alpha-numeric（その他）はFALSE
// trim()でスペースを全削除
export function onlySpaces(i){
    return i.trim().length == 0;
};

// emailアドレスのフォーマット確認
// 注意：「〇〇@〇〇.〇〇」のみに対応
// 問題なければTRUE 
export function validateEmail(i){
    return /\S+@\S+\.\S+/.test(i);
};

// Date()分活用
// 注意："0"の追加はしていない
// 注意：引数は "key" "type" 形式入力必須
export function timestamp(key, type){
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    const days = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ];
    const current = new Date();
    var now = {
        year: current.getFullYear(),
        month: current.getMonth() + 1,
        date: current.getDate(),
        day: current.getDay(), // 使わない
        hours: current.getHours(),
        minutes: current.getMinutes(),
        seconds: current.getSeconds(),
        milliseconds: current.getMilliseconds()
    };
    var nowtext = {
        monthtext: months[now.month - 1],
        daytext: days[now.day]
    };
    if (type == "n"){
        const nkeys = Object.keys(now);
        if (nkeys.includes(key)){
            log(now[key]);
            return now[key];
        }
        else{
            log("please check your parameters");
        }
    } else if (type == "t"){
        const tkeys = Object.keys(nowtext);
        if (tkeys.includes(key)){
            log(nowtext[key]);
            return nowtext[key];
        }
        else{
            log("please check your parameters");
        }
    };
};

// ファイルを作成＞ローカル保存
// 引数のfileName拡張を変更する事で、.txt以外の物にも対応可能
// 注意：JSONデータの場合、まず.stringify()が必要
export function downloadFile(content, fileName, contentType) {
    var a = document.createElement("a");
    var file = new Blob([content], {type: contentType});
    a.href = URL.createObjectURL(file);
    a.download = fileName;
    a.click();
};