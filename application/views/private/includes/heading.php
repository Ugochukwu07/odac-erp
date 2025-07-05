<div class="content-wrapper"> 
<style>
        

 .section-preview {
    border: 1px solid #e0e0e0;
    padding: 15px;
}

 .md-progress {
    position: relative;
    display: block;
    width: 100%;
    height: .25rem;
    margin-bottom: 1rem;
    overflow: hidden;
    background-color: #eee;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.primary-color-dark {
    background-color: #0d47a1 !important;
}
.progress {
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: 0.75rem;
    background-color: #e9ecef;
    border-radius: 0.25rem;
}

*, *::before, *::after {
    box-sizing: border-box;
}

.md-progress .indeterminate {
    background-color: #90caf9;
}

.md-progress .indeterminate::before {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    content: "";
    background-color: inherit;
    -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
    animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
    will-change: left, right;
}

.md-progress .indeterminate::after {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    content: "";
    background-color: inherit;
    -webkit-animation: indeterminate 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
    animation: indeterminate 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
    -webkit-animation-delay: 1.15s;
    animation-delay: 1.15s;
    will-change: left, right;
}
</style>
<!--
<section class="section-preview">

<div class="progress md-progress primary-color-dark">
<div class="indeterminate"></div>
</div>

</section>-->