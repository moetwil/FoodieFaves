export enum FieldMessageType {
  Success = 'is-success',
  Error = 'is-danger',
}

/**
 * @param {HTMLDivElement} el
 * @param {FieldMessageType} type
 * @param {string} message
 */
export function setFieldMessage(
  el: HTMLDivElement,
  type: FieldMessageType,
  message: string
): void {
  const field = el.closest('.field:not(.has-addons)') as HTMLDivElement;
  field.className = `field ${type}`;
  field.querySelector('p.help')!.textContent = message;
  let icon = '';
  if (type === FieldMessageType.Error) icon = 'fas fa-exclamation-triangle';
  else if (type === FieldMessageType.Success) icon = 'fas fa-check';
  field.querySelector('.icon i')!.className = icon;
}

export function clearFieldMessages(): void {
  document.querySelectorAll('.field:not(.has-addons)').forEach((field) => {
    const fieldEl = field as HTMLDivElement;
    fieldEl.className = 'field';
    fieldEl.querySelector('p.help')!.textContent = '';
    (fieldEl.querySelector('.icon i') as HTMLElement).className = '';
  });
}

export function hasAnyFieldErrors(): boolean {
  return document.querySelector('.field.is-danger') !== null;
}
