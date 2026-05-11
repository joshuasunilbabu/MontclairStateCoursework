import java.util.LinkedList;

public class Queue {
	private LinkedList<Task> queue;

	public Queue() {
		queue = new LinkedList<>();
	}

	public void enqueue(Task task) {
		queue.addLast(task);
	}

	public Task dequeue() {
		if (queue.isEmpty()) {
			System.out.println("Queue is empty!");
			return null;
		}
		return queue.removeFirst();
	}

	public boolean isEmpty() {
		return queue.isEmpty();
	}

	public String toString() {
		return queue.toString();
	}
}
