// 1
let a = 5;
let b = 2;

console.log(`Before swapping a is ${a} and b is ${b}`);
[a, b] = [b, a];

console.log(`After swapping a is ${a} and b is ${b}`);

// 2
function square(n) {
  return n*n;
};

let i;

for (i=1; i<=10; i++) {
  console.log(`The square of ${i} is : `, square(i));
}

// 3
let x;
const arr = [5, 10, 3, 58, 69, 15, 25, 32, 85, 75];
let largest = arr[0];

for (x = 0; x<arr.length; x++) {
  if (arr[x] > largest) {
    largest = arr[x];
  }
}
console.log(`Largest number is ${largest}`);
