<style>
    .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
}

.card {
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 20px;
    cursor: pointer;
    width: 280px; 
    height: 180px; 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center; 
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center; 
    align-items: center; 
    text-align: center;
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #8d4949;
    margin-bottom: 10px;
}

.card-text {
    font-size: 1rem;
    color: #555;
}

.addbtn {
    background-color: #8d4949;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    transition: background-color 0.3s ease;
}

.addbtn:hover {
    background-color: #bf6565;
}

.sp {
    margin-bottom: 30px;
    flex: 1 1 30%; 
}

</style>