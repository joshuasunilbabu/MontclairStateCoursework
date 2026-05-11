
public class Stack {
	private int size;
	private int top;
	private Task[] array;

	public Stack(int size) {
		this.size = size;
		this.top = -1;
		this.array = new Task[size];
	}

	public boolean empty() {
		return top == -1;
	}

	public void push(Task task) {
		if (top == size - 1) {
			System.out.println("Stack is full!");
			return;
		}
		array[++top] = task;
	}

	public Task pop() {
		if (top == -1) {
			System.out.println("Stack is empty!");
			return null;
		}
		return array[top--];
	}

	public String toString() {
		StringBuilder sb = new StringBuilder("[");
		for (int i = 0; i <= top; i++) {
			sb.append(array[i].toString()).append(", ");
		}
		sb.append("]");
		return sb.toString();
	}
}
