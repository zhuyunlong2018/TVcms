 //格式化时间
 const getTime = function() {
    let now = new Date();
    let year = now.getFullYear();
    let month = now.getMonth()+1;
    let day = now.getDate();
    let hour = now.getHours();
    let minute = now.getMinutes();
    let second = now.getSeconds();
    month = month.length < 2 ?  "0" + month : month;
    day = day.length < 2 ?  "0" + day : day;
    return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
  }

  export {getTime}