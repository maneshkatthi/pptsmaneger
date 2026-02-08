<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Select Roll</title>

<style>
:root{
    --bg:#f7f8fa;
    --bg2:#ebf2fa;
}

/* ===== BACKGROUND ===== */
html,body{
    margin:0;
    min-height:100%;
    display:grid;
    place-content:center;
    font-family:Arial,sans-serif;
    background:
        radial-gradient(hsl(220 10% 50% / .2) 1px, transparent 0),
        linear-gradient(160deg,var(--bg),var(--bg2));
    background-size:30px 30px,cover;
}

/* ===== CONTAINER (OUTER GLOW ONLY) ===== */
.container{
    width:520px;
    padding:30px;
    border-radius:20px;
    position:relative;
    background:rgba(255,255,255,.65);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.7);
    box-shadow:0 25px 40px rgba(0,0,0,.18);
}

/* outer glow */
.container::after{
    content:"";
    position:absolute;
    inset:-3px;
    border-radius:inherit;
    background:linear-gradient(
        120deg,
        oklch(.65 .15 260),
        oklch(.75 .18 280),
        oklch(.65 .15 240)
    );
    opacity:.35;
    filter:blur(12px);
    z-index:-1;
}

/* ===== FORM ===== */
h2{
    text-align:center;
    color:#3c5a80;
}
label{
    font-weight:600;
    color:#3c5a80;
}
select{
    width:100%;
    margin-top:10px;
    padding:12px;
    font-size:16px;
    border-radius:10px;
    border:1px solid #c7d3e3;
    background:white;
}

/* ===== IRIDESCENT BUTTON ===== */
button.iridescent{
    margin-top:24px;
    width:100%;
    height:64px;
    font-size:22px;
    font-family:"Amaranth",sans-serif;
    color:#818e9e;
    border-radius:99vw;
    border:3px solid transparent;
    cursor:pointer;
    background:
        linear-gradient(to bottom,
            oklch(.95 .01 257),
            oklch(.92 .0175 257 / 80%) 33%,
            oklch(.99 .01 257 / 80%)
        ) padding-box,
        linear-gradient(165deg,
            oklch(.94 .025 257 / 80%) 25%,
            oklch(.99 .01 257 / 80%)
        ) border-box;
    box-shadow:
        inset -6px -6px 6px -4px oklch(.99 .02 257),
        0 12px 20px rgba(0,0,0,.15);
    transition:.4s ease;
}
button.iridescent:hover{
    color:#3c5a80;
    box-shadow:
        inset -6px -6px 6px -4px oklch(.99 .02 257),
        0 18px 28px rgba(0,0,0,.25);
}

/* ===== FOOTER ===== */
footer{
    text-align:center;
    margin-top:26px;
    font-size:15px;
    letter-spacing:.4px;
    color:#6c84a6;
}
footer span{
    font-weight:600;
    background:linear-gradient(
        120deg,
        oklch(.35 .1 257),
        oklch(.45 .15 245),
        oklch(.55 .18 275)
    );
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    text-shadow:0 0 8px oklch(.85 .05 257 / 40%);
}
</style>
</head>

<body>

<div class="container">
<h2>CSM-F PPT Upload</h2>

<form action="upload.php" method="GET">
<label>Select Roll Number:</label>

<select name="roll" required>
<option value="">-- Select Roll --</option>

<option value="25H51A66P3">25H51A66P3</option>
<option value="25H51A66P4">25H51A66P4</option>
<option value="25H51A66P5">25H51A66P5</option>
<option value="25H51A66P6">25H51A66P6</option>
<option value="25H51A66P7">25H51A66P7</option>
<option value="25H51A66P8">25H51A66P8</option>
<option value="25H51A66P9">25H51A66P9</option>

<option value="25H51A66Q0">25H51A66Q0</option>
<option value="25H51A66Q1">25H51A66Q1</option>
<option value="25H51A66Q2">25H51A66Q2</option>
<option value="25H51A66Q3">25H51A66Q3</option>
<option value="25H51A66Q4">25H51A66Q4</option>
<option value="25H51A66Q5">25H51A66Q5</option>
<option value="25H51A66Q6">25H51A66Q6</option>
<option value="25H51A66Q7">25H51A66Q7</option>
<option value="25H51A66Q8">25H51A66Q8</option>
<option value="25H51A66Q9">25H51A66Q9</option>

<option value="25H51A66R0">25H51A66R0</option>
<option value="25H51A66R1">25H51A66R1</option>
<option value="25H51A66R2">25H51A66R2</option>
<option value="25H51A66R3">25H51A66R3</option>
<option value="25H51A66R4">25H51A66R4</option>
<option value="25H51A66R5">25H51A66R5</option>
<option value="25H51A66R6">25H51A66R6</option>
<option value="25H51A66R7">25H51A66R7</option>
<option value="25H51A66R8">25H51A66R8</option>
<option value="25H51A66R9">25H51A66R9</option>

<option value="25H51A66T0">25H51A66T0</option>
<option value="25H51A66T1">25H51A66T1</option>
<option value="25H51A66T2">25H51A66T2</option>
<option value="25H51A66T3">25H51A66T3</option>
<option value="25H51A66T4">25H51A66T4</option>
<option value="25H51A66T5">25H51A66T5</option>
<option value="25H51A66T6">25H51A66T6</option>
<option value="25H51A66T7">25H51A66T7</option>
<option value="25H51A66T8">25H51A66T8</option>
<option value="25H51A66T9">25H51A66T9</option>

<option value="25H51A66V0">25H51A66V0</option>
<option value="25H51A66V1">25H51A66V1</option>
<option value="25H51A66V2">25H51A66V2</option>
<option value="25H51A66V3">25H51A66V3</option>
<option value="25H51A66V4">25H51A66V4</option>
<option value="25H51A66V5">25H51A66V5</option>
<option value="25H51A66V6">25H51A66V6</option>
<option value="25H51A66V7">25H51A66V7</option>
<option value="25H51A66V8">25H51A66V8</option>
<option value="25H51A66V9">25H51A66V9</option>

<option value="25H51A66W0">25H51A66W0</option>
<option value="25H51A66W1">25H51A66W1</option>
<option value="25H51A66W2">25H51A66W2</option>
<option value="25H51A66W3">25H51A66W3</option>
<option value="25H51A66W4">25H51A66W4</option>
<option value="25H51A66W5">25H51A66W5</option>
<option value="25H51A66W6">25H51A66W6</option>
<option value="25H51A66W7">25H51A66W7</option>
<option value="25H51A66W8">25H51A66W8</option>
<option value="25H51A66W9">25H51A66W9</option>

<option value="25H51A66X0">25H51A66X0</option>
<option value="25H51A66X1">25H51A66X1</option>
<option value="25H51A66X2">25H51A66X2</option>
<option value="25H51A66X3">25H51A66X3</option>
<option value="25H51A66X4">25H51A66X4</option>
<option value="25H51A66X5">25H51A66X5</option>
<option value="25H51A66X6">25H51A66X6</option>

</select>

<button type="submit" class="iridescent">Continue</button>
</form>
</div>

<footer>
Developed by <span>Manesh Katthi</span>
</footer>

</body>
</html>
